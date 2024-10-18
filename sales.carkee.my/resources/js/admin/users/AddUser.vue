<template>
  <div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-body">
                    <h4 class="mb-4">Add New Staff</h4>
                    <form @submit.prevent="addNewUser">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label for="">Name</label>
                                    <span class="text-danger"> *</span>
                                    <input type="text" :class="['form-control', {'is-invalid': name_error}]" name="name" v-model="name">
                                    <span class="invalid-feedback" v-if="name_error" role="alert">
                                        <strong>{{ name_error }}</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label for="">Email</label>
                                    <span class="text-danger"> *</span>
                                    <input type="email" :class="['form-control', {'is-invalid': email_error}]" name="email" v-model="email">
                                    <span class="invalid-feedback" v-if="email_error" role="alert">
                                        <strong>{{ email_error }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label for="">Password</label>
                                    <span class="text-danger"> *</span>
                                    <input type="text" :class="['form-control', {'is-invalid': password_error}]" name="password" v-model="password">
                                    <span class="invalid-feedback" v-if="password_error" role="alert">
                                        <strong>{{ password_error }}</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label for="">Repeat Password</label>
                                    <span class="text-danger"> *</span>
                                    <input type="text" :class="['form-control', {'is-invalid': password_confirmation_error}]" name="password_confirmation" v-model="password_confirmation">
                                    <span class="invalid-feedback" v-if="password_confirmation_error" role="alert">
                                        <strong>{{ password_confirmation_error }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button class="btn btn-md btn-primary" type="submit">
                                        Submit
                                        <div class="spinner-border d-none" role="status"></div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
  </div>
</template>

<script>
import Swal from "sweetalert2";
export default {
    data() {
        return {
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
            name_error: '',
            email_error: '',
            password_error: '',
            password_confirmation_error: '',
        }
    },
    methods: {
        async addNewUser(e) {
            this.name_error = '';
            this.email_error = '';
            this.password_error = '';
            this.password_confirmation_error = '';
            e.target.disabled = true;
            document.querySelector('.spinner-border').classList.remove('d-none');
            await axios.post('/api/admin/users/store', {
                name: this.name,
                email: this.email,
                password: this.password,
                password_confirmation: this.password_confirmation,
            })
            .then(response => {
                e.target.disabled = false;
                document.querySelector('.spinner-border').classList.add('d-none');
                Swal.fire({
                    title: "Success",
                    text: response.data.message,
                    icon: "success",
                }).then((result) => {
                    this.$router.push("/admin/users");
                });
            })
            .catch(error => {
                if (error.response && error.response.status === 422) {
                    e.target.disabled = false;
                    document.querySelector('.spinner-border').classList.add('d-none');
                    const validationErrors = error.response.data.errors;
                    for (const field in validationErrors) {
                        if (this[`${field}_error`] !== undefined) {
                            this[`${field}_error`] = validationErrors[field][0];
                        }
                    }
                } else {
                    console.error("There was an error!", error);
                }
            });
        },
    },
    mounted() {
        document.title = 'Add New Staff';
    },
};
</script>
