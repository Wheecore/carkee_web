<template>
  <div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-body">
                    <h4 class="mb-4">Edit Customer</h4>
                    <form @submit.prevent="editCustomerDetails">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-4">
                                    <label for="">Name</label>
                                    <span class="text-danger"> *</span>
                                    <input type="text" :class="['form-control', {'is-invalid': name_error}]" name="name" v-model="name">
                                    <span class="invalid-feedback" v-if="name_error" role="alert">
                                        <strong>{{ name_error }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label for="">Phone</label>
                                    <span class="text-danger"> *</span>
                                    <input type="text" :class="['form-control', {'is-invalid': phone_error}]" name="phone" v-model="phone">
                                    <span class="invalid-feedback" v-if="phone_error" role="alert">
                                        <strong>{{ phone_error }}</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label for="">Fax</label>
                                    <span class="text-danger"> *</span>
                                    <input type="text" :class="['form-control', {'is-invalid': fax_error}]" name="fax" v-model="fax">
                                    <span class="invalid-feedback" v-if="fax_error" role="alert">
                                        <strong>{{ fax_error }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-4">
                                    <label for="">Address</label>
                                    <span class="text-danger"> *</span>
                                    <textarea :class="['form-control', {'is-invalid': address_error}]" rows="2" name="address" v-model="address"></textarea>
                                    <span class="invalid-feedback" v-if="address_error" role="alert">
                                        <strong>{{ address_error }}</strong>
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
import { decryptId } from '../../services/cryptoUtils';
export default {
    data() {
        return {
            name: '',
            phone: '',
            fax: '',
            address: '',
            name_error: '',
            phone_error: '',
            fax_error: '',
            address_error: '',
        }
    },
    methods: {
        decryptId,
        async editCustomerDetails(e) {
            this.name_error = '';
            this.phone_error = '';
            this.fax_error = '';
            this.address_error = '';
            e.target.disabled = true;
            document.querySelector('.spinner-border').classList.remove('d-none');
            await axios.post('/api/customers/update', {
                id: this.id,
                name: this.name,
                phone: this.phone,
                fax: this.fax,
                address: this.address,
            })
            .then(response => {
                e.target.disabled = false;
                document.querySelector('.spinner-border').classList.add('d-none');
                Swal.fire({
                    title: "Success",
                    text: response.data.message,
                    icon: "success",
                }).then((result) => {
                    this.$router.push("/customers");               
                });
            })
            .catch(error => {
                e.target.disabled = false;
                document.querySelector('.spinner-border').classList.add('d-none');
                if (error.response && error.response.status === 422) {
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
        async fetchCustomerDetails() {
            await axios.post('/api/customers/show', {
                id: this.id,
            })
            .then(response => {
                const user = response.data.user;
                this.name = user.name;
                this.phone = user.phone;
                this.fax = user.fax;
                this.address = user.address;
            })
            .catch(error => {
                console.error("There was an error!", error);
            });
        }
    },
    mounted() {
        document.title = 'Edit User';
        this.id = decryptId(this.$route.params.id);
        this.fetchCustomerDetails();
    },
};
</script>
