<script setup>
import { useRouter } from "vue-router";

const router = useRouter();

const goHome = () => {
  router.push("/");
};
</script>

<template>
  <div class="not-found">
    <div class="background"></div>

    <div class="content">
      <h1>404</h1>
      <h2>Страница не найдена</h2>
      <p>Возможно, ссылка устарела, страница была удалена или адрес введён неверно.</p>
      <button @click="goHome">Вернуться на главную</button>
    </div>
  </div>
</template>

<style scoped>
.not-found {
  position: relative;
  min-height: 100vh;

  display: flex;
  justify-content: center;
  align-items: center;

  overflow: hidden;

  background: #09090b;
  color: white;
}

.background {
  position: absolute;
  inset: 0;

  background:
      radial-gradient(circle at top left, rgba(0,132,255,.25), transparent 35%),
      radial-gradient(circle at bottom right, rgba(132,0,255,.18), transparent 40%);

  filter: blur(60px);
}

.content {
  position: relative;
  z-index: 2;

  width: min(700px, 90%);
  text-align: center;
}

h1 {
  font-size: clamp(120px, 18vw, 220px);
  line-height: .9;
  font-weight: 800;

  margin: 0;

  background: linear-gradient(135deg,#4f9cff,#7c4dff);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

h2 {
  margin-top: 10px;

  font-size: clamp(28px,4vw,42px);
  font-weight: 700;
}

p {
  margin: 25px auto 40px;

  max-width: 500px;

  color: #a1a1aa;

  line-height: 1.7;
  font-size: 17px;
}

button {
  border: none;
  outline: none;

  padding: 15px 34px;

  border-radius: 14px;

  background: linear-gradient(135deg,#3b82f6,#6366f1);

  color: white;

  font-size: 16px;
  font-weight: 600;

  cursor: pointer;

  transition: .25s;
}

button:hover {
  transform: translateY(-3px);
  box-shadow: 0 12px 35px rgba(79,156,255,.35);
}

button:active {
  transform: translateY(0);
}

@media (max-width:768px){

  h1{
    font-size:120px;
  }

  h2{
    font-size:30px;
  }

  p{
    font-size:15px;
  }

}
</style>