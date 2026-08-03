<script setup>
import {useProjects} from "@/composables/useProjects.js";
import {onMounted, ref, watch} from "vue";
import ProjectModal from "@/components/admin/modal/ProjectModal.vue";
import ConfirmModal from "@/components/admin/modal/ConfrimModal.vue";

const {
  projectItems,
  categoryTitle,
  loading,
  fetchProjects,
  submitting,
  submitError,
  adminCreateProjects,
  adminUpdateProjects,
  adminDeleteProjects,
  adminAddMedia,
  adminDeleteMedia
} = useProjects()

const isModalOpen = ref(false)
const selectedProject = ref(null)
const deleteModal = ref(false)
const projectToDelete = ref(null)
const createProject = async () => {
  selectedProject.value = false
  isModalOpen.value = true
}
const editProject = (project) => {
  selectedProject.value = project
  isModalOpen.value = true
}
const confirmDelete = (project) => {
  projectToDelete.value = project
  deleteModal.value = true
}
const deleteProject = async (project) => {
  if (!projectToDelete.value) return

  await adminDeleteProjects(projectToDelete.value.id)
  await fetchProjects(props.category.slug)

  deleteModal.value = false
  projectToDelete.value = null
}
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
const reloadProjects = async () => {
  await fetchProjects(props.category.slug)
}

watch(
    () => props.category?.slug,
    (newSlug, oldSlug) => {
      if (newSlug && newSlug !== oldSlug) {
        fetchProjects(newSlug)
      }
    },
    {immediate: true}
)

const emit = defineEmits([
  'open-projects',
  'back-category',
  'open-media',
  'back-project'
])

</script>

<template>
  <section class="projects">
    <div class="container">
      <button class="back" @click="emit('back-category')">Назад</button>
      <div class="project_title">
        <div>
          <h2>ПРОЕКТЫ</h2>
          <p class="subtitle">{{ category.title }}</p>
        </div>

        <button class="create-button" @click="createProject">
          + Добавить проект
        </button>
      </div>

      <div v-if="loading" class="loading">Loading...</div>

      <div v-else-if="!projectItems.length" class="empty">В этой категории пока нет проектов</div>

      <div v-else class="project_list">
        <div class="project_card" v-for="project in projectItems" :key="project.id">

          <div class="project_info">
            <div class="project_header">
              <h3>{{ project.title }}</h3>
              <span class="project_date">{{ project.project_date }}</span>
            </div>

            <p>{{ project.description }}</p>
          </div>

          <div class="project_actions">
            <button @click="emit('open-media', project)" class="media">Медиа</button>
            <button @click="editProject(project)" class="edit">Редактировать</button>
            <button @click="confirmDelete(project)" class="delete">Удалить</button>
          </div>
        </div>
      </div>
    </div>
  </section>

  <ProjectModal
      :is-open="isModalOpen"
      :project="selectedProject"
      :category="category"
      @close="isModalOpen = false"
      @saved="reloadProjects"
  />
  <ConfirmModal
      :is-open="deleteModal"
      title="Удалить проект?"
      :text="`Проект «${projectToDelete?.title}» будет удален без возможности восстановления.`"
      confirm-text="Удалить"
      cancel-text="Отмена"
      @confirm="deleteProject"
      @close="deleteModal = false"
  />

</template>


<style scoped>
button {
  color: white;
}

.container {
  display: flex;
  flex-direction: column;
  gap: 30px;
}

.back {
  padding: 12px 22px;
  background: #111;
  border: 1px solid #333;
  border-radius: 8px;
  cursor: pointer;
  transition: .25s;
  max-width: 200px;
}

.back:hover {
  transform: translateY(-2px);
}

.projects {
  width: 100%;

  display: flex;
  flex-direction: column;
  gap: 30px;
}

.project_title {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 20px;

  flex-wrap: wrap;
}

.project_title h2 {
  font-size: 34px;
  font-weight: 400;
  margin-bottom: 6px;
}

.subtitle {
  color: #777;
  font-size: 15px;
}

.create-button {
  padding: 12px 22px;

  background: #111;

  border: 1px solid #333;

  border-radius: 8px;

  cursor: pointer;

  transition: .25s;
}

.create-button:hover {
  background: #14532d;
  border-color: #16a34a;
  color: white;

  transform: translateY(-2px);
}

.project_list {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.project_card {
  display: flex;
  justify-content: space-between;
  gap: 30px;

  padding: 24px;

  background: #111;

  border: 1px solid #222;

  border-radius: 12px;

  transition: .25s;
}

.project_card:hover {
  border-color: #444;
}

.project_info {
  flex: 1;
}

.project_header {
  display: flex;
  justify-content: space-between;
  align-items: center;

  gap: 20px;

  margin-bottom: 18px;
}

.project_header h3 {
  font-size: 24px;
  font-weight: 400;
}

.project_date {
  color: #888;
  font-size: 14px;
}

.project_info p {
  color: #aaa;
  line-height: 1.6;
}

.project_actions {
  display: flex;
  flex-direction: column;
  justify-content: center;

  gap: 12px;

  width: 220px;
}

.project_actions button {
  padding: 12px;

  background: transparent;

  border: 1px solid #333;

  border-radius: 8px;

  cursor: pointer;

  transition: .25s;
}

.project_actions button:hover {
  transform: translateY(-2px);
}

.edit:hover {
  background: #8e5618;
  border-color: #e18212;
  color: white;
}

.media:hover {
  background: #1d4ed8;
  border-color: #2563eb;
  color: white;
}

.delete:hover {
  background: #7f1d1d;
  border-color: #dc2626;
  color: white;
}

.loading,
.empty {
  padding: 60px;

  text-align: center;

  color: #777;

  border: 1px dashed #333;

  border-radius: 12px;
}

@media (max-width: 900px) {

  .project_card {
    flex-direction: column;
  }

  .project_actions {
    width: 100%;

    flex-direction: row;
  }

  .project_actions button {
    flex: 1;
  }

}

@media (max-width: 600px) {

  .project_header {
    flex-direction: column;
    align-items: flex-start;
  }

  .project_actions {
    flex-direction: column;
  }

  .create-button {
    width: 100%;
  }

  .project_title {
    flex-direction: column;
    align-items: stretch;
  }

}
</style>
