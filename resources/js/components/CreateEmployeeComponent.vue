<template>
    <div class="container vh-100 d-flex flex-column justify-content-center align-items-center">
        <!-- Login Card -->
        <div class="card p-4 mb-3" style="width: 100%; max-width: 400px;">
            <div class="card-header text-center">
                <h5>CREATE AN EMPLOYEE</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">First name</label>
                    <input v-model="firstName" type="text" class="form-control" id="exampleFormControlInput1" placeholder="Employee's first name">
                </div>

                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Last Name</label>
                    <input v-model="lastName" type="text" class="form-control" id="exampleFormControlInput1" placeholder="Employee's last name">
                </div>

                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Password</label>
                    <input v-model="password" type="password" class="form-control" id="exampleFormControlInput1" placeholder="Password">
                </div>

                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Employee's Department</label>
                    <select v-model="department_id" class="form-select">
                        <option value="">Select a Department</option>
                        <option v-for="dept in departments" :key="dept.id" :value="dept.id">{{ dept.name }}</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Employee's type</label>
                    <select v-model="type" class="form-select">
                        <option value="">Select a type</option>
                        <option value="regular">Regular</option>
                        <option value="admin_room_911">Room 911 Admin</option>
                    </select>
                </div>

                <div class="d-grid">
                    <button v-on:click="send_employee()" type="button" class="btn btn-primary">Create Employee</button>
                </div>

            </div>
        </div>

        <!-- Access Room 911 Button below the card -->
        <div class="d-grid" style="width: 100%; max-width: 400px;">
            <button v-on:click="backToHome()" type="button" class="btn btn-primary">Back to home</button>
        </div>
    </div>
</template>

<script>

    import axios from 'axios';

    export default {
        mounted() {
            this.getDepartments();
            console.log('Component mounted.')
        },

        data() {
            return {
                password: "",
                firstName: "",
                lastName: "",
                department_id: "",
                type: "", 
                departments: []
            }
        },

        methods:{
            async send_employee(){
                try {
                // Using axios to send a POST request
                const response = await axios.post('/api/createemployee', {
                    password : this.password,
                    firstName : this.firstName,
                    lastName : this.lastName,
                    department_id : this.department_id,
                    type : this.type
                });

                console.log(response)
                alert(response.data.message)

                this.password = "";
                this.firstName = "";
                this.lastName = "";
                this.department_id = "";
                this.type = "";



                // if (response.data.permission){
                //     window.location.href = "http://127.0.0.1:8000/home"
                // }
                
                }

                 catch (error) {
                console.error('Error attempting access:', error);
                alert('An error occurred. Please try again.');
            }
            },

            goToAccess(){
                window.location.href = "http://127.0.0.1:8000/access"
            },

            async getDepartments(){
                let response = await axios.get('/api/getdepartments');
                this.departments = response.data.departments;
            }, 

            backToHome(){
                window.location.href = "http://127.0.0.1:8000/home"
            }
        }
    }
</script>
