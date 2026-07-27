<script setup>
import {useReviews} from "@/composables/useReviews.js";
import {onMounted, ref} from "vue";

const {reviewItems, loading, submitting, adminFetchReviews, adminChangeStatus} = useReviews();


const status = ref('pending')
const filters = ref({
  status: '',
})

const applyFilters = () => {
  adminFetchReviews(filters.value)
}
const accept = async (review) => {
  status.value = 'accepted'
  await adminChangeStatus(review.id, status.value)
  await adminFetchReviews()
}
const reject = async (review) => {
  status.value = 'rejected'
  await adminChangeStatus(review.id, status.value)
  await adminFetchReviews()
}
onMounted(async () => {
  await adminFetchReviews();
})
</script>

<template>
  <section class="reviews-page">
    <div class="container">

      <div class="page-header">
        <h1>Отзывы</h1>

        <div class="filter">
          <button :class="{ active: !filters.status }" @click="filters.status=null; applyFilters()">Все</button>
          <button :class="{ active: filters.status === 'pending' }" @click="filters.status='pending'; applyFilters()">На
            рассмотрении
          </button>
          <button :class="{ active: filters.status === 'accepted' }" @click="filters.status='accepted'; applyFilters()">
            Приняты
          </button>
          <button :class="{ active: filters.status === 'rejected' }" @click="filters.status='rejected'; applyFilters()">
            Отклонены
          </button>
        </div>
      </div>
      <div class="loading" v-if="loading">Loading...</div>
      <div class="loading" v-else-if="!reviewItems.length">Здесь ничего нет</div>
      <div class="reviews" v-else>
        <div class="reviews_overlay" v-for="review in reviewItems" :key="review.id">
          <div class="review_text">
            <div class="review_author">
              <h3>{{ review.name }}</h3>
              <p>{{ review.title }}</p>
            </div>
            <p>{{ review.description }}</p>
            <p class="status" :class="review.status">
              {{ review.status }}
            </p>
          </div>
          <div class="review_buttons">
            <button @click="accept(review)" v-if="review.status !== 'accepted'" :disabled="submitting">{{ submitting ? 'Сохранение...' : 'Принять' }}</button>
            <button @click="reject(review)" v-if="review.status !== 'rejected'" :disabled="submitting">{{ submitting ? 'Сохранение...' : 'Отклонить' }}</button>
          </div>
        </div>
      </div>
    </div>

  </section>
</template>

<style scoped>
.status {
  display: inline-block;
  padding: 4px 10px;
  border-radius: 20px;
  font-size: 13px;
  margin-bottom: 20px;
}
.container {
  display: flex;
  flex-direction: column;
  gap: 30px;
}
.page-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 20px;
  flex-wrap: wrap;
}

.page-header h1 {
  font-size: 34px;
  font-weight: 400;
}

.reviews-page {
  width: 100%;
  display: flex;
  flex-direction: column;
  gap: 30px;
}

.status.pending {
  background: rgba(234, 179, 8, .15);
  color: #facc15;
}

.status.accepted {
  background: rgba(34, 197, 94, .15);
  color: #4ade80;
}

.status.rejected {
  background: rgba(239, 68, 68, .15);
  color: #f87171;
}

.filter {
  display: flex;
  flex-wrap: wrap;
  gap: 12px;
}

.filter button {
  padding: 10px 18px;
  background: transparent;
  border: 1px solid #333;
  color: #aaa;
  border-radius: 8px;
  cursor: pointer;
  transition: background-color .3s ease,
  border-color .3s ease,
  color .3s ease;
}

.filter button:hover {
  background: #2a2a2a;
  color: #fff;
}

.filter button.active {
  background: #fff;
  color: #111;
  border-color: #fff;
}

.reviews {
  display: grid;
  grid-template-columns:repeat(auto-fill, minmax(360px, 1fr));
  gap: 24px;
}

.reviews_overlay {
  background: #111;
  border: 1px solid #222;
  border-radius: 10px;
  padding: 20px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  transition: border-color .3s ease, transform .2s ease;
}

.reviews_overlay:hover {
  border-color: #444;
  transform: translateY(-3px);
}

.review_author {
  margin-bottom: 15px;
}

.review_author h3 {
  font-size: 22px;
  font-weight: 400;
  margin-bottom: 4px;
}

.review_author p {
  font-size: 14px;
  color: #777;
}

.review_text > p {
  line-height: 1.6;
  color: #ddd;
  margin-bottom: 20px;
}

.review_buttons {
  display: flex;
  gap: 12px;
}

.review_buttons button {
  flex: 1;
  background: transparent;
  border: 1px solid #333;
  color: #aaa;
  padding: 10px;
  border-radius: 8px;
  cursor: pointer;
  transition: background-color .3s ease,
  border-color .3s ease,
  color .3s ease;
}

.review_buttons button:first-child:hover {
  background: #14532d;
  border-color: #16a34a;
  color: #fff;
}

.review_buttons button:last-child:hover {
  background: #7f1d1d;
  border-color: #dc2626;
  color: #fff;
}

.review_buttons button:disabled {
  opacity: .5;
  cursor: not-allowed;
}

@media (max-width: 700px) {

  .page-header {
    flex-direction: column;
    align-items: stretch;
  }

  .filter {
    width: 100%;
  }

  .filter button {
    flex: 1;
  }

  .reviews {
    grid-template-columns:1fr;
  }

  .review_buttons {
    flex-direction: column;
  }

  .review_buttons button {
    width: 100%;
  }

}
</style>