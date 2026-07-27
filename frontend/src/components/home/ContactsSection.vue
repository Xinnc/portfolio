<script setup>
import {useSettings} from "@/composables/useSettings.js"
import {onMounted} from "vue";

const {settingItems, loading, fetchSettings} = useSettings()

onMounted(() => {
      fetchSettings()
    }
)
</script>

<template>
  <section class="contacts" id="contacts">
    <div class="container">
      <div class="contact_content">
        <div class="contact_title">
          <h2>Контакты</h2>
          <p>Открыта для сотрудничества и интересных проектов</p>
        </div>
        <div class="loading" v-if="loading">Loading...</div>
        <div v-else class="contact_items">
          <div class="contact_links">
            <a class="contact_item" :href="`https://t.me/${settingItems.telegram}`" target="_blank">
              <img src="@/assets/icons/telegram-2.svg" alt="icon">
              <div class="contact_text">
                <h4>Telegram</h4>
                <p>{{settingItems.telegram}}</p>
              </div>
            </a>
            <a class="contact_item" :href="`https://vk.com/${settingItems.vk}`" target="_blank">
              <img src="@/assets/icons/vk-5.svg" alt="icon">
              <div class="contact_text">
                <h4>VK</h4>
                <p>{{settingItems.vk}}</p>
              </div>
            </a>
            <a class="contact_item" :href="`https://max.ru/u/${settingItems.max}`" target="_blank">
              <img src="@/assets/icons/Max_logo_black.svg" alt="icon">
              <div class="contact_text">
                <h4>Max</h4>
                <p>{{settingItems.max}}</p>
              </div>
            </a>
          </div>

          <div class="contact_links">
            <a class="contact_item" :href="`https://wa.me/${settingItems.whatsapp}`" target="_blank">
              <img src="@/assets/icons/whatsapp-12.svg" alt="icon">
              <div class="contact_text">
                <h4>Whatsapp*</h4>
                <p>{{settingItems.whatsapp}}</p>
              </div>
            </a>
            <a class="contact_item" :href="`https://instagram.com/${settingItems.instagram}`" target="_blank">
              <img src="@/assets/icons/instagram-53.svg" alt="icon">
              <div class="contact_text">
                <h4>Instagram*</h4>
                <p>{{settingItems.instagram}}</p>
              </div>
            </a>
            <p class="meta">*Meta — признана экстремистской организацией, её деятельность запрещена на территории Российской Федерации.</p>
          </div>
        </div>

      </div>
    </div>
  </section>
</template>

<style scoped>
.meta{
  color: #787878;
}
.contacts{
  position: relative;
  overflow: hidden;
  padding: 40px 0;
}
.contacts::before {
  content: '';
  position: absolute;
  inset: 0;
  z-index: 0;
  background:
      linear-gradient(to right, rgba(13, 13, 13, 11) 0%, rgba(13, 13, 13, 0.9) 60%, transparent 100%),
      url('@/assets/images/contact_bg.jpg') center center / cover no-repeat;
}
.container{
  position: relative;
  z-index: 1;
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
}
.contact_content{
  display: flex;
  flex-direction: column;
}
.contact_content:before{
  background-image: url('@/assets/images/contact_bg.jpg');
}
.contact_content h2{
  font-size: 52px;
  font-weight: 500;
  letter-spacing: 0.06em;
  margin-bottom: 10px;
}
.contact_content p{
  font-size: 18px;
  letter-spacing: 0.1em;
  color: #787878;
}
.contact_title{
  margin-bottom: 30px;
  font-size: 18px;
  font-weight: 500;
  letter-spacing: 0.15em;
}

.contact_links{
  margin-top: 30px;
  display: flex;
  gap: 20px;
  flex-direction: column;
}
.contact_items{
  display: flex;
  gap: 80px;
  justify-content: space-between;
}
.contact_item{
  gap: 15px;
  display: flex;
}
.contact_item img{
  width:50px;
  height:50px;
  object-fit:contain;
  filter: brightness(0) saturate(100%) invert(1);
  flex-shrink:0;
}
.contact_text{
  padding: 3px 0;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}
.contact_item{
  gap:15px;
  display:flex;
  align-items:center;

  transition:.25s;
}

.contact_item:hover{
  transform:translateX(8px);
}

.contact_item:hover h4{
  color:#fff;
}

.contact_item:hover p{
  transition: 0.3s;
  color:#cfcfcf;
}
@media(max-width: 768px){
  .contact_items{
    flex-direction: column;
    justify-content: center;
    gap: 0;
  }
  .contact_content p{
    font-size: 14px;
  }
}
</style>