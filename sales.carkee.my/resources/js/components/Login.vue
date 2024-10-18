<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-lg-4 col-sm-12 mx-auto">
                <div class="card shadow mt-5">
                    <div class="card-body">
                        <div id="auth-left">
                            <div class="auth-logo"></div>
                            <h1 class="display-3 fw-bold">Log in.</h1>
                            <p class="auth-subtitle mb-5">Log in with your data that you entered during registration.</p>
                            <form @submit.prevent="submitForm">
                            <div class="form-group position-relative has-icon-left mb-4">
                                <input type="text" :class="['form-control form-control-xl', {'is-invalid': email_error}]" placeholder="Email Address" name="email" v-model="email">
                                <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                                </div>
                                <span class="invalid-feedback" role="alert" v-if="email_error" :style="{ display: 'block' }">
                                <strong>{{ email_error }}</strong>
                                </span>
                            </div>
                            <div class="form-group position-relative has-icon-left mb-4">
                                <input type="password" :class="['form-control form-control-xl', {'is-invalid': password_error}]" placeholder="Password" name="password" v-model="password">
                                <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                                </div>
                                <span class="invalid-feedback" role="alert" v-if="password_error" :style="{ display: 'block' }">
                                <strong>{{ password_error }}</strong>
                                </span>
                            </div>
                            <div class="d-grid mt-4">
                                <span class="invalid-feedback mb-3" role="alert" v-if="unauthorized_error" :style="{ display: 'block' }">
                                <strong>{{ unauthorized_error }}</strong>
                                </span>
                                <button class="btn btn-primary btn-lg fw-bold" type="submit">Log In</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
  data() {
    return {
      email: "",
      password: "",
      email_error: "",
      password_error: "",
      unauthorized_error: "",
    };
  },
  methods: {
    async submitForm() {
      this.email_error = '';
      this.password_error = '';
      await axios.post('/api/login', {
        email: this.email,
        password: this.password,
      })
      .then(response => {
        localStorage.setItem('token', response.data.token);
        localStorage.setItem('role', response.data.role);
        localStorage.setItem('id', response.data.id);
        localStorage.setItem('name', response.data.name);
        if (response.data.role == 1) {
          window.location.href = '/admin/dashboard';
          // this.$router.push("/admin/dashboard");
        } else {
          window.location.href = '/dashboard';
          // this.$router.push("/dashboard");
        }
      })
      .catch(error => {
        if (error.response && error.response.status === 422) {
          const validationErrors = error.response.data.errors;
          for (const field in validationErrors) {
            if (this[`${field}_error`] !== undefined) {
              this[`${field}_error`] = validationErrors[field][0];
            }
          }
        } else if (error.response && error.response.status === 401) {
          this.unauthorized_error = 'Account not found';
        } else {
          console.error("There was an error!", error);
        }
      });
    },
  },
  mounted() {
    document.title = 'Login';
  },
};
</script>
<style>
@import "../assets/css/bootstrap5.min.css";
@import "../assets/css/style.css";
</style>
