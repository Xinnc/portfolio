<script setup>
import {onMounted, ref} from "vue";
import {useCategories} from "@/composables/useCategories.js";
import CategoryModal from "@/components/admin/modal/CategoryModal.vue";
import ConfirmModal from "@/components/admin/modal/ConfrimModal.vue"

const { adminFetchCategories, adminDeleteCategories, loading, categoryItems} = useCategories();

onMounted(async () => {
  await adminFetchCategories()
})

const isModalOpen = ref(false)
const selectedCategory = ref(null)

const createCategory = () => {
  selectedCategory.value = null
  isModalOpen.value = true
}

const editCategory = (category) => {
  selectedCategory.value = category
  isModalOpen.value = true
}

const deleteModal = ref(false)
const categoryToDelete = ref(null)

const confirmDelete = (category) => {
  categoryToDelete.value = category
  deleteModal.value = true
}

const deleteCategory = async () => {
  if (!categoryToDelete.value) return

  await adminDeleteCategories(categoryToDelete.value.id)
  await adminFetchCategories()

  deleteModal.value = false
  categoryToDelete.value = null
}
const emit = defineEmits([
  'open-projects',
  'back-category',
  'open-media',
  'back-project'
])
const props = defineProps({
  category: {
    type: Object,
    default: null
  },
  project: {
    type: Object,
    default: null
  }
})
</script>

<template>
  <section class="category" id="categories">
    <div class="container">
      <div class="category_title">
        <h2>КАТЕГОРИИ</h2>
        <div class="category-create">
          <button class="create-button" @click="createCategory"> Добавить категорию </button>
        </div>
      </div>
      <div class="category_list">
        <div class="loading" v-if="loading">Loading...</div>
        <div class="loading" v-else-if="!categoryItems">Здесь ничего нет</div>

        <div class="category-card" v-for="category in categoryItems" :key="category.id">
          <img :src="category.url" class="category-image" alt="cover_image">

          <div class="category-info">
            <h3>{{ category.title }}</h3>
            <p>{{ category.description }}</p>
            <small> slug: {{ category.slug }} </small>
            <small> порядок: {{ category.sort_order }} </small>
          </div>

          <div class="category-actions">
            <button @click="emit('open-projects', category)"> Проекты </button>
            <button @click="editCategory(category)"> Редактировать </button>
            <button @click="confirmDelete(category)"> Удалить </button>
          </div>
        </div>
      </div>
    </div>
  </section>
  <CategoryModal
      :is-open="isModalOpen"
      :category="selectedCategory"
      @close="isModalOpen = false"
      @saved="adminFetchCategories"
  />
  <ConfirmModal
      :is-open="deleteModal"
      title="Удалить категорию?"
      :text="`Категория «${categoryToDelete?.title}» будет удалена без возможности восстановления.`"
      confirm-text="Удалить"
      cancel-text="Отмена"
      @confirm="deleteCategory"
      @close="deleteModal = false"
  />
</template>

<style scoped>
.category-create {
  display: flex;
  align-items: center;
}

.create-button {
  padding: 10px 18px;
  background: #111;
  border: 1px solid #222;
  border-radius: 6px;
  cursor: pointer;
  transition: .25s;
}

.create-button:hover {
  background: #14532d;
  border-color: #16a34a;
  color: #fff;
}
.container {
  display: flex;
  flex-direction: column;
  gap: 30px;
}

.category_title {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 20px;
  flex-wrap: wrap;
}

.category_list {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.category-card {
  display: flex;
  align-items: center;
  gap: 24px;

  padding: 22px;

  background: #111;
  border: 1px solid #222;
  border-radius: 10px;

  transition: .25s;
}

.category-card:hover {
  border-color: #444;
}

.category-image {
  width: 190px;
  height: 130px;

  object-fit: cover;

  border-radius: 8px;
  flex-shrink: 0;
}

.category-info {
  flex: 1;
}

.category-info h3 {
  margin-bottom: 12px;

  font-size: 24px;
  font-weight: 400;
}

.category-info p {
  margin-bottom: 16px;

  color: #a8a8a8;
  line-height: 1.5;
}

.category-info small {
  display: block;

  color: #666;
  line-height: 1.5;
}

.category-actions {
  display: flex;
  flex-direction: column;
  gap: 20px;
  width: 220px;
}

.category-actions button,
.create-button {
  padding: 12px 18px;

  background: transparent;

  border: 1px solid #333;
  border-radius: 8px;

  color: #ddd;

  cursor: pointer;

  transition:
      background .25s,
      border-color .25s,
      color .25s,
      transform .2s;
}

.category-actions button:hover,
.create-button:hover {
  transform: translateY(-2px);
}

.category-actions button:first-child:hover{
    background:#1d4ed8;
    border-color:#2563eb;
    color:white;
}

.category-actions button:nth-child(2):hover {
  background: #8e5618;
  border-color: #e18212;
  color: white;
}

.category-actions button:last-child:hover {
  background: #7f1d1d;
  border-color: #dc2626;
  color: white;
}

@media (max-width: 900px) {

  .category-card {
    flex-wrap: wrap;
    align-items: flex-start;
  }

  .category-image {
    width: 170px;
    height: 120px;
  }

  .category-actions {
    width: 100%;

    flex-direction: row;
    justify-content: flex-end;

    margin-top: 10px;
  }

  .category-actions button {
    flex: 1;
  }

}

@media (max-width: 650px) {

  .category-card {
    flex-direction: column;
    align-items: stretch;
  }

  .category-image {
    width: 100%;
    height: 220px;
  }

  .category-info {
    text-align: left;
  }

  .category-actions {
    width: 100%;
    flex-direction: column;
  }

  .category-actions button {
    width: 100%;
  }

  .category_title {
    flex-direction: column;
    align-items: stretch;
  }

  .create-button {
    width: 100%;
  }

}
</style>