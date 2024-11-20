<template>
    <div class="container my-5">
      <!-- Header -->
      <h2>Room 911 - Employee Management</h2>
      <div class="d-flex justify-content-between mb-4">
        <!-- Logout Button -->
        <button @click="goToLogin()" class="btn btn-outline-secondary">Logout</button>
      </div>
  

	  <div class="d-grid" style="width: 100%; max-width: 400px;">
            <button v-on:click="downloadPdf()" type="button" class="btn btn-primary">Export to PDF</button>
      </div>

      <!-- Employee Table -->
      <div class="table-responsive">
        <table id = "table" class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>Employee ID</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="att in attemptList" :key="att.id">
              <td>{{ att.employee_id }}</td>
              <td>{{ att.time }}</td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="d-grid" style="width: 100%; max-width: 400px;">
            <button v-on:click="backToHome()" type="button" class="btn btn-primary">Back to home</button>
      </div>
  
      <!-- Modal Components -->
      <!-- <EditEmployeeModal v-if="showEditModal" :employee="selectedEmployee" @close="showEditModal = false" />
      <AddEmployeeModal v-if="showAddEmployeeModal" @close="showAddEmployeeModal = false" /> -->
    </div>
  </template>

<script>

    import axios from 'axios';
    import html2pdf from "html2pdf.js";

    export default {

        props: {
            id: Number
        },

        mounted() {
            this.getAttempts()
            this.getEmployees()
            this.getDepartments()
            console.log('Component mounted.')
        },

        data() {
            return {
                employee_id: "",
                password: "",
                name: "",
                department_id: "",
                startDate: "",
                endDate: "",
                filteredEmployees: [],
                departments: [],
                attemptList: []
            }
        },

        methods:{
            async send_id(){
                try {
                // Using axios to send a POST request
                const response = await axios.post('/api/login', {
                    employee_id: this.employee_id,
                    password : this.password
                });

                console.log(response)
                alert(response.data.message)
                
                }

                 catch (error) {
                console.error('Error attempting access:', error);
                alert('An error occurred. Please try again.');
            }
            },

            async getDepartments(){
                let response = await axios.get('/api/getdepartments');
                this.departments = response.data.departments;
            },  

            async getEmployees(){
                let response = await axios.get('/api/getemployees',
                {
                    params: { // Add the params object here
                    employee_id: this.employee_id,
                    name: this.name,
                    department_id: this.department_id,
                    startDate: this.startDate,
                    endDate: this.endDate
                    }
                }
                )
                this.filteredEmployees = response.data.employees
                
            },

            goToAccess(){
                window.location.href = "http://127.0.0.1:8000/access"
            },

            clearFilters() {
                this.employee_id = "";
                this.name = "";
                this.department_id = "";
                this.startDate = "";
                this.endDate = "";
                this.getEmployees(); // Refresh employee list without filters
            },

            getDepartmentName(departmentId) {
                const department = this.departments.find(dept => dept.id === departmentId);
                return department ? department.name : 'Unknown'; // Return the department name or 'Unknown' if not found
            },

            async changeType(employee_id, employee_type) {

                console.log(employee_id)
                console.log(employee_type)

                const response = await axios.put('/api/changetype', 
                {
                     
                    id_to_modify: employee_id,
                    actual_type: employee_type
                    
                }
                );
                await this.getEmployees()

                console.log(response);
            },

            goToNewEmployee(){
                window.location.href = "http://127.0.0.1:8000/createemployee"
            },

            goToEditEmployee(id){
                window.location.href = "http://127.0.0.1:8000/editemployee/" + id;
            },

            goToLogin(){
                window.location.href = "http://127.0.0.1:8000/";
            },

            backToHome(){
                window.location.href = "http://127.0.0.1:8000/home"
            },

            async deleteEmployee(id){

                console.log(id)

                const response = await axios.delete('/api/deleteemployee/' + id);

                console.log(response);

                alert(response.data.message);
                await this.getEmployees();
            },

            async getAttempts(){
                let response = await axios.get('/api/listattempts',
                {
                    params:{
                      employee_id: this.id,
                    }
                    
                }
                )

                console.log(this.id)
                console.log(response)
                this.attemptList = response.data.attemptlist
                
            },
            
            downloadPdf(){
				const element = document.getElementById("table");
				const options = {
					margin: 0.5, 
					filename: "tabla.pdf",
					image: { type: "jpeg", quality: 0.98 },
					html2canvas: { scale: 2 }, 
					jsPDF: { unit: "in", format: "letter", orientation: "portrait" }
				};

				html2pdf().set(options).from(element).save();


            }

            

        }
    }
</script>
