<template>
    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="card p-4" style="width: 100%; max-width: 400px;">
            <div class="card-header text-center">
                <h5>ROOM 911 Authentication</h5>
            </div>
            <div class="card-body">
                
                <div class="mb-3">
                    <input v-model="employee_id" type="text" class="form-control" placeholder="Your ID" aria-label="ID input">
                </div>
                
                <div class="d-grid">
                    <button v-on:click="send_id()" type="button" class="btn btn-primary">ACCESS</button>
                </div>
            </div>
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
            }
        },

        methods:{
            async send_id(){
                try {
                // Using axios to send a POST request
                const response = await axios.post('/api/send', {
                    employee_id: this.employee_id
                });

                console.log(response)
                alert(response.data.message)
                
                }

                 catch (error) {
                console.error('Error attempting access:', error);
                alert('An error occurred. Please try again.');
            }
            }
        }
    }
</script>
