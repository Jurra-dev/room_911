<template>
    <div class="container vh-100 d-flex flex-column justify-content-center align-items-center">
        <!-- Login Card -->
        <div class="card p-4 mb-3" style="width: 100%; max-width: 400px;">
            <div class="card-header text-center">
                <h5>LOGIN</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <input v-model="employee_id" type="text" class="form-control" placeholder="Your ID" aria-label="ID input">
                </div>

                <div class="mb-3">
                    <input v-model="password" type="password" class="form-control" placeholder="Password" aria-label="Password input">
                </div>
                
                <div class="d-grid">
                    <button v-on:click="send_id()" type="button" class="btn btn-primary">Enter</button>
                </div>
            </div>
        </div>

        <!-- Access Room 911 Button below the card -->
        <div class="d-grid" style="width: 100%; max-width: 400px;">
            <button v-on:click="goToAccess()" type="button" class="btn btn-primary">ACCESS ROOM 911</button>
        </div>
    </div>
</template>

<script>

    import axios from 'axios';

    export default {
        mounted() {
            console.log('Component mounted.')
        },

        data() {
            return {
                employee_id: "",
                password: ""
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

                if (response.data.permission){
                    window.location.href = "http://127.0.0.1:8000/home"
                }
                
                }

                 catch (error) {
                console.error('Error attempting access:', error);
                alert('An error occurred. Please try again.');
            }
            },

            goToAccess(){
                window.location.href = "http://127.0.0.1:8000/access"
            }
        }
    }
</script>
