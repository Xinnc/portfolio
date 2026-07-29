<script setup>
import { useAuthStore } from '@/stores/auth.js'
import { useRouter } from 'vue-router'
import {ref, computed} from "vue";
import Categories from "@/components/admin/Categories.vue";
import Reviews from "@/components/admin/Reviews.vue";
import Settings from "@/components/admin/Settings.vue";
import Projects from "@/components/admin/Projects.vue";
import Media from "@/components/admin/Media.vue";

const authStore = useAuthStore()
const router = useRouter()

const logout = async () => {
  await authStore.logout()
  router.push('/login')
}

const pages = {
  categories: Categories,
  projects: Projects,
  reviews: Reviews,
  settings: Settings,
  media: Media,
}

const currentComponent = computed(() => pages[currentPage.value.page]);
const currentPage = ref({
  page: 'categories',
  category: null,
  project: null,
})

const openProjects = (category) => {
  currentPage.value.category = category
  currentPage.value.page = 'projects'
}
const openMedia = (project) => {
  currentPage.value.project = project
  currentPage.value.page = 'media'
}

const mobileMenu = ref(false)

const toggleMenu = () => {
  mobileMenu.value = !mobileMenu.value
}
const closeMenu = () => {
  mobileMenu.value = false
}
</script>

<template>
  <div class="admin-layout">
    <header class="mobile-header">
      <h2>Админ</h2>
      <button class="burger" @click="toggleMenu">☰</button>
    </header>
    <div class="sidebar-overlay" :class="{ show: mobileMenu }" @click="closeMenu"/>

    <aside class="admin-sidebar" :class="{open: mobileMenu}">
      <div class="sidebar-header">
        <h2>Админ</h2>
      </div>
      <nav>
        <button class="router-link" @click="currentPage.page = 'categories'; closeMenu();">Категории</button>
        <button class="router-link" @click="currentPage.page = 'reviews'; closeMenu();">Отзывы</button>
        <button class="router-link" @click="currentPage.page = 'settings'; closeMenu();">Контакты</button>
      </nav>
      <button @click="logout" class="logout-btn">Выйти</button>
    </aside>
    <div class="admin-content">
      <keep-alive>
        <component
            :is="currentComponent"
            :category="currentPage.category"
            :project="currentPage.project"
            @back-project="currentPage.page = 'projects'"
            @open-projects="openProjects"
            @open-media="openMedia"
            @back-category="currentPage.page = 'categories'"
        />
      </keep-alive>
    </div>
  </div>
</template>

<style scoped>
.admin-layout {
  display: flex;
  min-height: 100vh;
  background: #0d0d0d;
}
.admin-sidebar {
  width: 240px;
  background: #111;
  border-right: 1px solid #222;
  padding: 30px 20px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}
.sidebar-header h2 {
  font-size: 22px;
  font-weight: 300;
  margin-bottom: 40px;
  letter-spacing: 1px;
}
.admin-sidebar nav {
  display: flex;
  flex-direction: column;
  gap: 8px;
}
.admin-sidebar nav a {
  padding: 10px 16px;
  border-radius: 8px;
  color: #aaa;
  transition: 0.2s;
  text-decoration: none;
}
.admin-sidebar nav a:hover {
  background: #1a1a1a;
  color: #fff;
}
.router-link {
  background: transparent;
  border: 1px solid #333;
  color: #aaa;
  padding: 10px;
  border-radius: 8px;
  cursor: pointer;
  font-size: 14px;
  transition: background-color .3s ease,
  color .3s ease,
  border-color .3s ease,
  transform .2s ease;
}
.router-link:hover {
  background: #2a2a2a;
  color: #fff;
}
.admin-sidebar nav button.active {
  background: var(--text);
  color: var(--background);
  border-color: var(--text);
}
.logout-btn {
  background: transparent;
  border: 1px solid #333;
  color: #aaa;
  padding: 10px;
  border-radius: 8px;
  cursor: pointer;
  transition: 0.3s;
  font-size: 14px;
}
.logout-btn:hover {
  background: #2a2a2a;
  color: #fff;
}
.admin-content {
  width: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 40px 30px;
}
.mobile-header{
  display:none;
}

.sidebar-overlay{
  display:none;
}
@media (max-width:900px){

  .mobile-header{

    display:flex;

    align-items:center;

    justify-content:space-between;

    padding:18px 20px;

    position:fixed;

    top:0;
    left:0;
    right:0;

    background:#111;

    border-bottom:1px solid #222;

    z-index:1000;
  }

  .mobile-header h2{
    font-size:22px;
    font-weight:300;
  }

  .burger{

    width:42px;
    height:42px;

    background:none;

    border:1px solid #333;

    border-radius:8px;

    color:white;

    cursor:pointer;

    font-size:22px;
  }

  .admin-sidebar{

    position:fixed;

    top:0;
    left:0;

    bottom:0;

    z-index:1100;

    transform:translateX(-100%);

    transition:.3s;
  }

  .admin-sidebar.open{

    transform:translateX(0);
  }

  .sidebar-overlay{

    position:fixed;

    inset:0;

    background:rgba(0,0,0,.55);

    opacity:0;

    pointer-events:none;

    transition:.3s;

    z-index:1050;
  }

  .sidebar-overlay.show{

    opacity:1;

    pointer-events:auto;
  }

  .admin-content{

    padding-top:95px;
  }

}
</style>