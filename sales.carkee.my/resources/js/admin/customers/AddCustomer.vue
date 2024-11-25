<template>
  <div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-body">
                    <h4 class="mb-4">Add New Customer</h4>
                    <form @submit.prevent="addNewCustomer">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-4">
                                    <label for="">Company Name</label>
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
									<label for="">Company Number</label>
									<input type="text" :class="['form-control', {'is-invalid': name_error}]" name="company-number" v-model="company_number">
									<span class="invalid-feedback" v-if="name_error" role="alert">
                                        <strong>{{ name_error }}</strong>
                                    </span>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group mb-4">
									<label for="">Company Phone</label>
									<span class="text-danger"> *</span>
									<input type="text" :class="['form-control', {'is-invalid': name_error}]" name="company-phone" v-model="company_phone">
									<span class="invalid-feedback" v-if="name_error" role="alert">
                                        <strong>{{ name_error }}</strong>
                                    </span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group mb-4">
									<label for="">PIC Name</label>
									<span class="text-danger"> *</span>
									<input type="text" :class="['form-control', {'is-invalid': name_error}]" name="pic-name" v-model="pic_name">
									<span class="invalid-feedback" v-if="name_error" role="alert">
                                        <strong>{{ name_error }}</strong>
                                    </span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group mb-4">
									<label for="">PIC Phone</label>
									<span class="text-danger"> *</span>
									<input type="text" :class="['form-control', {'is-invalid': name_error}]" name="pic-phone" v-model="pic_phone">
									<span class="invalid-feedback" v-if="name_error" role="alert">
                                        <strong>{{ name_error }}</strong>
                                    </span>
								</div>
							</div>
						</div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-4">
                                    <label for="">Email</label>
                                    <span class="text-danger"> *</span>
                                    <input type="text" :class="['form-control', {'is-invalid': fax_error}]" name="email" v-model="email">
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
export default {
    data() {
        return {
            name: '',
			company_number: '',
			company_phone: '',
			pic_name: '',
			pic_phone: '',
			email: '',
            address: '',
            name_error: '',
            address_error: '',
        }
    },
    methods: {
        async addNewCustomer(e) {
            e.target.disabled = true;
            document.querySelector('.spinner-border').classList.remove('d-none');
            await axios.post('/api/customers/store', {
                id: localStorage.getItem('id'),
                name: this.name,
				company_phone: this.company_phone,
				company_number: this.company_number,
				pic_name: this.pic_name,
				pic_phone: this.pic_phone,
                email: this.email,
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
                    this.$router.push("/admin/customers");
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
        document.title = 'Add New Customer';
    },
};
</script>
