<script setup>

</script>

<template>
<section class="about">
  <div class="container">
    <div class="about_title">
      <h2>ОБО МНЕ</h2>
    </div>
    <div class="about_images">
      <img src="@/assets/images/valeria_photo1.JPG" alt="Валерия">
      <img src="@/assets/images/vcaleria_photo2.JPG" alt="Валерия">
      <img src="@/assets/images/valeria_photo3.JPG" alt="Валерия">
    </div>
    <div class="about_description">
      <p>Снимаю видео, которые хочется пересматривать. 
Я работаю с визуальным контентом: фотографией, видео и созданием креативных концепций. Как фотограф, видеограф, оператор и контент-продюсер, я помогаю превращать идеи в проекты, которые цепляют и остаются в памяти. Для меня важны не только красивая картинка, но и смысл, атмосфера и внимание к деталям. Беру на себя весь процесс - от идеи и съемки до финального результата, чтобы каждый проект выглядел цельным и работал именно так, как должен.</p>
      <p>Я работаю с изображениями, чтобы рассказывать истории.</p>
      <p>Я работаю с изображениями, чтобы рассказывать истории.</p> 
      <p>Я работаю с изображениями, чтобы рассказывать истории.</p>
    </div>
    <div class="about_diploma">
      <img src="@/assets/images/diplom1.JPG" alt="Диплом специалиста">
      <img src="@/assets/images/diplom2.JPG" alt="Диплом специалиста">
      <img src="@/assets/images/diplom3.JPG" alt="Диплом специалиста">
      <img src="@/assets/images/diplom1.JPG" alt="Диплом специалиста">
    </div>
  </div>
</section>
</template>

<style scoped>
.about_diploma{
  display: flex;
  gap: 20px;
  justify-content: center;
}
.about_diploma img{
  max-width: 300px;
  max-height: 150px;
}
.about{
  border-bottom: 1px solid var(--border);
  padding: 40px 0;
}
.container{
  display: flex;
  flex-direction: column;
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
}
.about_title{
  margin-bottom: 30px;
  font-size: 18px;
  font-weight: 500;
  letter-spacing: 0.15px;
}
.about_images{
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
}
.about_images img{
  width: 100%;
  aspect-ratio: 3/5;
  object-fit: cover;
  border: 1px solid var(--border);
}
.about_description{
  margin: 60px;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 10px;
  font-size:24px;
  line-height:1.2;
  font-weight:300;
}

@media (max-width: 1024px) {
  .about_description {
    margin: 40px;
    font-size: 20px;
  }

  .about_diploma img {
    max-width: 250px;
    max-height: 125px;
  }
}

/* Планшеты */
@media (max-width: 768px) {
  .about {
    padding: 30px 0;
  }

  .about_title {
    font-size: 16px;
    margin-bottom: 25px;
  }

  .about_title h2 {
    font-size: 28px;
  }

  .about_images {
    grid-template-columns: 1fr 1fr;
    max-width: 400px;
    margin: 0 auto;
  }
  .about_images img:last-child {
    display: none;
  }
  .about_images img:first-child,
  .about_images img:nth-child(2) {
    aspect-ratio: 4/5;
  }
  .about_images img {
    aspect-ratio: 4/5;
  }

  .about_description {
    margin: 30px 0;
    font-size: 18px;
    gap: 8px;
  }

  .about_diploma {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
    max-width: 300px;
    margin: 0 auto;
  }

  .about_diploma img {
    width: 100%;
    aspect-ratio: 1/1;
    object-fit: cover;
    max-width: 100%;
    max-height: 100%;
    border: 1px solid var(--border);
    border-radius: 4px;
  }
}

/* Мобильные телефоны */
@media (max-width: 500px) {
  .about {
    padding: 20px 0;
  }

  .container {
    padding: 0 15px;
  }

  .about_title {
    font-size: 14px;
    margin-bottom: 20px;
  }

  .about_title h2 {
    font-size: 22px;
  }

  .about_images {
    display: flex;
    justify-content: center;
    align-items: center;
    max-width: 300px;
    margin: 0 auto;
    gap: 0;
  }

  /* Скрываем все картинки кроме второй */
  .about_images img:first-child,
  .about_images img:last-child {
    display: none;
  }

  /* Показываем только вторую картинку по центру */
  .about_images img:nth-child(2) {
    display: block;
    width: 100%;
    aspect-ratio: 3/4;
    object-fit: cover;
    border-radius: 4px;
    border: 1px solid var(--border);
  }

  .about_description {
    margin: 25px 15px;
    font-size: 16px;
    gap: 8px;
  }

  .about_description p {
    text-align: center;
    padding: 0 5px;
  }

  .about_diploma {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
    max-width: 300px;
    margin: 0 auto;
  }

  .about_diploma img {
    width: 100%;
    aspect-ratio: 1/1;
    object-fit: cover;
    max-width: 100%;
    max-height: 100%;
    border: 1px solid var(--border);
    border-radius: 4px;
  }
}

/* Очень маленькие телефоны */
@media (max-width: 380px) {
  .about_title h2 {
    font-size: 18px;
  }

  .about_images {
    max-width: 250px;
  }

  .about_images img {
    aspect-ratio: 2/3;
  }

  .about_description {
    font-size: 14px;
    margin: 20px 0;
  }

  .about_diploma img {
    max-width: 100px;
    max-height: 50px;
  }
}

/* Для экранов с высоким разрешением */
@media (min-width: 1400px) {
  .container {
    max-width: 1400px;
  }

  .about_description {
    font-size: 28px;
    margin: 80px;
  }

  .about_diploma img {
    max-width: 350px;
    max-height: 175px;
  }
}
</style>
