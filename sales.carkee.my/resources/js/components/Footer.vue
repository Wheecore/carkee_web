<template>
  <footer class="container-fluid d-flex justify-content-end">
    <small> Copyright &copy; {{ getCurrentYear() }} Carkee Sales All Rights Reserved </small>
  </footer>
</template>

<script>
export default {
  methods: {
    getCurrentYear() {
      const currentYear = new Date().getFullYear();
      return currentYear;
    }
  }
};
</script>

