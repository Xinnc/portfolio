<script setup>
const scrollToPortfolio = () => {
  const section = document.getElementById('categories');
  if (section) {
    section.scrollIntoView({
      behavior: 'smooth'
    })
  }
}
</script>

<template>
  <section class="hero">
    <div class="hero__overlay"></div>

    <div class="container">
      <div class="hero__content">
        <h1 class="hero__title">VISUAL PORTFOLIO</h1>
        <div class="hero__services">
          <p>Валерия</p>
          <p>|</p>
          <p>Фотограф</p>
          <p>|</p>
          <p>Видеограф</p>
          <p>|</p>
          <p>Монтажёр</p>
          <p>|</p>
          <p>Контент-продюсер</p>
        </div>

        <img src="@/assets/icons/arrow_down.svg" alt="icon" class="hero__button" @click="scrollToPortfolio" />
      </div>
    </div>

  </section>
</template>

<style scoped>

.hero {
  position: relative;
  min-height: 100vh;
  display: flex;
  align-items: center;
  background: url('@/assets/images/sneaky_vampire.gif') center center / cover no-repeat;
  overflow: hidden;
}

.hero__overlay {
  position: absolute;
  inset: 0;
  background: rgba(0, 0, 0, .55);
  backdrop-filter: blur(2px);
}

.container {
  position: relative;
  z-index: 2;
  width: min(var(--container), calc(100% - 48px));
  margin: 0 auto;
}

.hero__content{
  display: flex;
  flex-direction: column;
  align-items: center;
}

.hero__title {
  display: flex;
  font-size: 120px;
  line-height: .92;
  font-weight: 400;
  color: white;
  letter-spacing: -.05em;
  text-transform: uppercase;
}

.hero__services {
  margin-top: 48px;
  display: flex;
  align-items: center;
  flex-wrap: wrap;
  gap: 18px;
  color: rgba(255, 255, 255, .85);
  font-size: 18px;
  font-weight: 300;
}

.hero__services span:nth-child(even) {
  width: 6px;
  height: 6px;
  border-radius: 50%;
  background: rgba(255, 255, 255, .45);
}

.hero__button {
  filter: brightness(0) saturate(100%) invert(1);
  margin-top: 60px;
  width: 56px;
  height: 56px;
  background: transparent;
  color: white;
  cursor: pointer;
  font-size: 28px;
  transition: .3s;
}

.hero__button:hover {
  filter: brightness(0) saturate(100%) invert(0);

}

@media (max-width:1200px){

  .hero__title{
    font-size:96px;
    text-align:center;
  }

  .hero__services{
    margin-top:36px;
    font-size:17px;
    gap:14px;
  }

}

/* ============================= */
/* Планшеты */
/* ============================= */
@media (max-width:900px){

  .hero__title{
    font-size:72px;
    line-height:1;
    text-align:center;
  }

  .hero__services{
    justify-content:center;
    gap:12px;
    font-size:16px;
    max-width:650px;
  }

}

/* ============================= */
/* Телефоны */
/* ============================= */
@media (max-width:768px){

  .hero{
    min-height:100svh;
  }

  .container{
    width:calc(100% - 32px);
  }

  .hero__title{
    font-size:48px;
    line-height:1.05;
    letter-spacing:-.03em;
    text-align:center;
  }

  .hero__services{

    margin-top:28px;

    justify-content:center;

    gap:8px 14px;

    font-size:15px;

    line-height:1.6;

    max-width:340px;

    text-align:center;
  }

  .hero__button{
    width:48px;
    height:48px;
    margin-top:40px;
  }

}

/* ============================= */
/* Маленькие телефоны */
/* ============================= */
@media (max-width:480px){

  .hero__title{
    font-size:38px;
  }

  .hero__services p{
    text-align:center;
    font-size:15px;
  }

  .hero__button{
    margin-top:32px;
    width:42px;
    height:42px;
  }

}
</style>