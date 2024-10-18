<template>
    <div>
        <Aside />
        <div class="content">
            <div class="content-header">
                <a id="contentMenu" href="#" class="content-menu d-none d-lg-flex"><i data-feather="menu"></i></a>
                <a id="mobileMenu" href="#" class="content-menu d-lg-none"><i data-feather="menu"></i></a>
                <div class="page-heading d-lg-none">
                    <h3>Carkee Sales</h3>
                </div>
            </div>
            <div class="content-body px-3 px-lg-5">
                <router-view></router-view>
                <Footer />
            </div>
        </div>
    </div>
</template>
<script>
import '../assets/lib/bootstrap/js/bootstrap.bundle.min.js';
import '../assets/lib/perfect-scrollbar/perfect-scrollbar.min.js';
import '../assets/js/script.js';
import '../assets/js/custom.js';

import Aside from "../user/includes/Aside.vue";
import Footer from "./Footer.vue";

export default {
  components: {
    Aside,
    Footer,
  }
};
</script>
<style>
@import "../assets/css/bootstrap5.min.css";
@import "../assets/css/style.css";
@import "../assets/css/custom.css";
</style>
