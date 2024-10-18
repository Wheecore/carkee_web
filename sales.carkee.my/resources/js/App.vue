<template>
  <div>
    <div v-if="authenticated">
      <AdminLayout v-if="role == 1" />
      <UserLayout v-else />
    </div>
    <LoginComponent v-else />
  </div>
</template>

<script>
import AdminLayout from "./components/AdminLayout.vue";
import UserLayout from "./components/UserLayout.vue";
import LoginComponent from "./components/Login.vue";

export default {
  components: {
    LoginComponent,
    AdminLayout,
    UserLayout,
  },
  data() {
    return {
      authenticated: false,
      role: localStorage.getItem("role"),
    };
  },
  async created() {
    await axios
      .get("/api/user", {
        headers: {
          Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
      })
      .then((response) => {
        this.authenticated = true;
      })
      .catch((error) => {
        if (error.response && error.response.status === 401) {
          this.authenticated = false;
        } else {
          console.error("There was an error!", error);
        }
      });
  }
};
</script>
<style></style>
