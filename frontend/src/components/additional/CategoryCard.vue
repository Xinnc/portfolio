<script setup>
defineProps({
  category: Object
})
</script>

<template>
  <router-link :to="{name: 'category', params: { slug:category.slug}}" class="category_link">
    <article class="category_item" :style="{backgroundImage: `url(${category.url})`}">
      <div class="category_overlay">
        <h4>{{category.title}}</h4>
        <p>{{category.description}}</p>
      </div>
    </article>
  </router-link>
</template>

<style scoped>
.category_link {
  flex: 1 1 280px;
  max-width: 320px;
  min-width: 260px;

  display: block;

  color: inherit;
  text-decoration: none;

  overflow: hidden;

  transition:
      transform .25s ease,
      box-shadow .25s ease;
}

.category_link:hover {
  transform: translateY(-8px);
  box-shadow: 0 18px 40px rgba(0,0,0,.45);
}

.category_item {
  position: relative;

  height: 500px;

  display: flex;
  align-items: flex-end;

  background-size: cover;
  background-position: center;

  border: 1px solid var(--border);

  overflow: hidden;
}
.category_item::after{
  content: '';
  position: absolute;
  inset: 0;
  background-image:inherit;
  background-size:cover;
  background-position:center;

  z-index:0;

  transition:.5s;
}

.category_link:hover .category_item::after{
  transform:scale(1.08);
}

.category_item::before {
  content: "";

  position: absolute;
  inset: 0;

  background: rgba(0,0,0,.45);

  transition: background .25s ease;
}

.category-card:hover .category_item::before {
  background: rgba(0,0,0,.6);
}

.category_overlay {
  position: relative;
  z-index: 2;

  width: 100%;

  padding: 28px 24px;

  display: flex;
  flex-direction: column;
  gap: 12px;

  background: linear-gradient(
      to top,
      rgba(0,0,0,.92),
      rgba(0,0,0,.55),
      transparent
  );
}

.category_overlay h4{
  margin: 0;

  font-size: 28px;
  font-weight: 300;
  line-height: 1.2;

  color: #fff;
}

.category_overlay p{
  margin: 0;

  color: var(--color-text);

  font-size: 18px;
  line-height: 1.35;

  display: -webkit-box;
  -webkit-box-orient: vertical;
  -webkit-line-clamp: 2;
  overflow: hidden;
}

@media (max-width: 992px) {

  .category_link{
    flex: 1 1 calc(50% - 10px);
    max-width: calc(50% - 10px);
    min-width: 0;
  }

  .category_item{
    height: 420px;
  }

  .category_overlay{
    padding:22px 18px;
  }

  .category_overlay h4{
    font-size:24px;
  }

  .category_overlay p{
    font-size:16px;
  }

}

@media (max-width: 768px){

  .category_link{
    flex:1 1 100%;
    max-width:100%;
  }

  .category_item{
    height:360px;
  }

  .category_overlay{
    padding:20px 16px;
    gap:8px;
  }

  .category_overlay h4{
    font-size:22px;
  }

  .category_overlay p{
    font-size:15px;
    line-height:1.4;
  }

}

@media (max-width:480px){

  .category_item{
    height:300px;
  }

  .category_overlay{
    padding:16px;
  }

  .category_overlay h4{
    font-size:20px;
  }

  .category_overlay p{
    font-size:14px;
  }

}
</style>