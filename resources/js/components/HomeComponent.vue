<template>
    <div class="container my-5">
      <!-- Header -->
      <h2>Room 911 - Employee Management</h2>
      <div class="d-flex justify-content-between mb-4">
        <!-- Logout Button -->
        <button @click="goToLogin()" class="btn btn-outline-secondary">Logout</button>
      </div>
  
      <!-- Filters Section -->
      <div class="filters mb-4">

        <!-- ID filter -->
        <input
            v-model="employee_id" 
            type="text" 
            class="form-control" 
            placeholder="Search by ID"
            @input="getEmployees" 
        >
        <!-- Department filter -->
        <select 
            v-model="department_id" 
            class="form-select" 
            @change="getEmployees"
        >
            <option value="">All Departments</option>
            <option v-for="dept in departments" :key="dept.id" :value="dept.id">{{ dept.name }}</option>
        </select>

        <!-- Start Date filter -->
        <input 
            v-model="startDate" 
            type="date" 
            class="form-control" 
            @input="getEmployees"
        >

        <!-- End Date Filter -->
        <input 
            v-model="endDate" 
            type="date" 
            class="form-control" 
            @input="getEmployees"
        >

        <!-- Clear all filters -->
        <button class="btn btn-warning" @click="clearFilters">Clear Filters</button>
      </div>
  
      <!-- Employee Table -->
      <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Department</th>
              <th>Successful Accesses</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="employee in filteredEmployees" :key="employee.id">
              <td>{{ employee.id }}</td>
              <td>{{ employee.firstname }}</td>
              <td>{{ employee.lastname }}</td>
              <td>{{ getDepartmentName(employee.department_id) }}</td>
              <td>{{ employee.totalaccess }}</td>
              <td>
                <button class="btn btn-sm btn-info" @click="goToEditEmployee(employee.id)">Update</button>
                <button class="btn btn-sm btn-warning" @click="changeType(employee.id, employee.type)">
                  {{ employee.type === 'admin_room_911' ? 'Disable' : 'Enable' }}
                </button>
                <button class="btn btn-sm btn-primary" @click="goToAccessHistory(employee.id)">History</button>
                <button class="btn btn-sm btn-danger" @click="deleteEmployee(employee.id)" >Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
  
      <!-- Add Employee and CSV Upload -->
      <div class="d-flex justify-content-between mt-4">
        <button @click = "goToNewEmployee()" class="btn btn-success" >Add New Employee</button>
        <!-- <input type="file" accept=".csv" class="form-control-file"> -->
      </div>

      <div class="mb-3">
        <label for="formFile" class="form-label">Load CSV file</label>
        <input @change="handleFileUpload" accept=".csv" class="form-control" type="file" id="formFile">
    </div>

    <div class="d-flex justify-content-between mt-4">
        <button @click = "loadCSV()" class="btn btn-success" >Load Employees in CSV</button>
        <!-- <input type="file" accept=".csv" class="form-control-file"> -->
      </div>
    
  
      <!-- Modal Components -->
      <!-- <EditEmployeeModal v-if="showEditModal" :employee="selectedEmployee" @close="showEditModal = false" />
      <AddEmployeeModal v-if="showAddEmployeeModal" @close="showAddEmployeeModal = false" /> -->
    </div>
  </template>

<script>

    import axios from 'axios';

    export default {
        mounted() {
            this.getEmployees()
            this.getDepartments()
            console.log('Component mounted.')
        },

        data() {
            return {
                csvData: [],
                employee_id: "",
                password: "",
                name: "",
                department_id: "",
                startDate: "",
                endDate: "",
                filteredEmployees: [],
                departments: [],
                rows: []
            }
        },

        methods:{

            async loadCSV(){
                const rawArray = JSON.parse(JSON.stringify(this.rows));

                console.log(rawArray);
                for (let i = 1; i < rawArray.length; i++){

                    if(rawArray[i].length === 5){

                        const response = await axios.post('/api/createemployee', {
                            password : rawArray[i][2],
                            firstName : rawArray[i][0],
                            lastName : rawArray[i][1],
                            department_id : rawArray[i][3],
                            type : rawArray[i][4].replace(/\r$/, '')
                        });

                        // console.log("HEY")
                        // console.log(response.data)
                    }

                }
            },

            handleFileUpload(event) {
                const file = event.target.files[0];
                if (file && file.type === "text/csv") {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                    const text = e.target.result;
                    this.processCSV(text);
                    };
                    reader.readAsText(file);
                } else {
                    alert("Por favor, selecciona un archivo CSV válido.");
                }
                },

            processCSV(csvText) {
                
                const rows = csvText.split("\n");

                
                const processedRows = rows.map(row => row.split(","));

                
                this.rows = processedRows;

                console.log(this.rows);
            },

            async send_id(){
                try {
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
                    params: { 
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
                return department ? department.name : 'Unknown'; 
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

            goToAccessHistory(id){
                window.location.href = "http://127.0.0.1:8000/listattempts/" + id;
            },

            goToLogin(){
                window.location.href = "http://127.0.0.1:8000/";
            },

            async deleteEmployee(id){

                console.log(id)

                const response = await axios.delete('/api/deleteemployee/' + id);

                console.log(response);

                alert(response.data.message);
                await this.getEmployees();
            }

        }
    }
</script>
