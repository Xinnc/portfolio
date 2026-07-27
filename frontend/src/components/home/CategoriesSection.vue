<script setup>
import {useCategories} from "@/composables/useCategories.js"
import {onMounted} from "vue";
import CategoryCard from "@/components/additional/CategoryCard.vue";

const {categoryItems, loading, fetchCategories} = useCategories()

onMounted(() => {
      fetchCategories()
    }
)
</script>

<template>
  <section class="category" id="categories">
    <div class="container">
      <div class="category_title">
        <h2>КАТЕГОРИИ</h2>
      </div>
      <div class="category_list">
        <div class="loading" v-if="loading">Loading...</div>
        <CategoryCard
          v-else
          v-for="category in categoryItems"
          :key="category.id"
          :category="category"
          />
      </div>
    </div>
  </section>
</template>

<style scoped>
.category {
  border-bottom: 1px solid var(--border);
  padding: 40px 0;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
}

.category_title {
  margin-bottom: 30px;
  font-size: 18px;
  font-weight: 500;
  letter-spacing: 0.15px;
}

.category_list {
  display: flex;
  gap: 20px;
  justify-content: center;
}

.category_overlay h4 {
  font-size: 26px;
  font-weight: 200;
  line-height: 1.2;
  margin-bottom: 8px;
  color: var(--text);
  text-shadow: 0 2px 8px rgba(0, 0, 0, 0.5);
}

.category_overlay p {
  font-size: 18px;
  line-height: 1.3;
  color: var(--color-text);
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

@media (max-width:1024px){

  .container{
    padding:0 18px;
  }

  .category_list{
    gap:16px;
    flex-wrap:wrap;
  }

}

/* ========================= */
/* Планшеты */
/* ========================= */
@media (max-width:768px){

  .category{
    padding:32px 0;
  }

  .container{
    padding:0 16px;
  }

  .category_title{
    margin-bottom:20px;
  }

  .category_title h2{
    font-size:28px;
  }

  .category_list{
    gap:16px;
    flex-wrap:wrap;
    justify-content:center;
  }

}

/* ========================= */
/* Телефоны */
/* ========================= */
@media (max-width:480px){

  .category{
    padding:24px 0;
  }

  .container{
    padding:0 14px;
  }

  .category_title{
    text-align:center;
    margin-bottom:18px;
  }

  .category_title h2{
    font-size:24px;
  }

  .category_list{
    gap:14px;
  }

}
</style>