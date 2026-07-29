<script setup>
  import {useCategories} from "@/composables/useCategories.js";
  import {onMounted} from "vue";

  defineProps({review:Object})
</script>

<template>
  <div class="review_text">
    <div class="review_author">
      <h3>{{ review.name }}</h3>
      <p>{{ review.title }}</p>
    </div>
    <p>{{ review.description }}</p>
  </div>
</template>

<style scoped>
.review_text {
  max-width: 900px;
  margin: 0 auto 20px;
  text-align: center;
  display: flex;
  flex-direction: column;
  gap: 10px;
}
.review_text p{
  font-size: 34px;
  line-height: 1.4;
  font-weight: 300;
  margin-bottom: 50px;

  display: -webkit-box;
  -webkit-line-clamp: 5;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
}

.review_author {
  display: flex;
  flex-direction: column;
  gap: 3px;
}
.review_author h3 {
  font-size: 26px;
  line-height: 1.4;
  font-weight: 300;
}
.review_author p {
  font-size: 16px;
  line-height: 1.4;
  font-weight: 300;
  color: var(--color-text)
}
@media (max-width:992px){

  .review_text{
    max-width:100%;
    padding:0 20px;
  }

  .review_text p{
    font-size:28px;
    margin-bottom:40px;
  }

  .review_author h3{
    font-size:22px;
  }

}

/* ============================= */
/* Телефоны */
/* ============================= */
@media (max-width:768px){

  .review_text{
    padding:0 10px;
    gap:8px;
  }

  .review_text p{
    font-size:22px;
    line-height:1.5;
    margin-bottom:30px;

    -webkit-line-clamp:6;
  }

  .review_author h3{
    font-size:20px;
  }

  .review_author p{
    font-size:15px;
  }

}

/* ============================= */
/* Маленькие телефоны */
/* ============================= */
@media (max-width:480px){

  .review_text p{
    font-size:18px;
    margin-bottom:24px;
  }

  .review_author h3{
    font-size:18px;
  }

  .review_author p{
    font-size:14px;
  }

}
</style>