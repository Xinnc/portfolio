<script setup>
import {onMounted, ref} from "vue";
import {useSettings} from "@/composables/useSettings.js";

const {settingItems, loading, fetchSettings, submitting, submittingError, updateSettings} = useSettings();

const successMessage = ref('')
const form = ref({
  telegram: '',
  vk: '',
  max: '',
  instagram: '',
  whatsapp: ''
})
const onSubmit = async () => {
  const result = await updateSettings(form.value)
  if (result.success) {
    await fetchSettings()
    form.value = {
      telegram: '',
      vk: '',
      max: '',
      instagram: '',
      whatsapp: ''
    }
    successMessage.value = 'Данные успешно изменены'
  }
}

onMounted(async () => {
  await fetchSettings()
})
</script>

<template>
  <section class="settings">
    <h1>Контакты</h1>
    <div class="loading" v-if="loading">Loading...</div>
    <div class="loading" v-else-if="!settingItems">Здесь ничего нет</div>
    <div class="settings_overlay" v-else>
      <div class="settings_link">
        <img src="@/assets/icons/telegram-2.svg" alt="icon">
        <div class="contact_text">
          <h4>Telegram</h4>
          <p>{{ settingItems.telegram }}</p>
        </div>
      </div>
      <div class="settings_link">
        <img src="@/assets/icons/vk-5.svg" alt="icon">
        <div class="contact_text">
          <h4>VK</h4>
          <p>{{ settingItems.vk }}</p>
        </div>
      </div>
      <div class="settings_link">
        <img src="@/assets/icons/Max_logo_black.svg" alt="icon">
        <div class="contact_text">
          <h4>Max</h4>
          <p>{{ settingItems.max }}</p>
        </div>
      </div>
      <div class="settings_link">
        <img src="@/assets/icons/whatsapp-12.svg" alt="icon">
        <div class="contact_text">
          <h4>Whatsapp</h4>
          <p>{{ settingItems.whatsapp }}</p>
        </div>
      </div>
      <div class="settings_link">
        <img src="@/assets/icons/instagram-53.svg" alt="icon">
        <div class="contact_text">
          <h4>Instagram</h4>
          <p>{{ settingItems.instagram }}</p>
        </div>
      </div>
    </div>
    <div class="settings_btn">
      <h2>Изменить свои данные</h2>
      <button @click="onSubmit" :disabled="submitting">{{ submitting ? 'Сохранение...' : 'Сохранить' }}</button>
    </div>
    <div class="settings_error" v-if="submittingError">{{ submittingError }}</div>
    <div class="settings_update">
      <div class="settings_input">
        <p>Telegram</p>
        <input v-model="form.telegram" placeholder="telegram"/>
      </div>
      <div class="settings_input">
        <p>VK</p>
        <input v-model="form.vk" placeholder="vk"/>
      </div>
      <div class="settings_input">
        <p>Max</p>
        <input v-model="form.max" placeholder="max"/>
      </div>
      <div class="settings_input">
        <p>Whatsapp</p>
        <input v-model="form.whatsapp" placeholder="whatsapp"/>
      </div>
      <div class="settings_input">
        <p>Instagram</p>
        <input v-model="form.instagram" placeholder="instagram"/>
      </div>
    </div>
  </section>
</template>

<style scoped>
.settings {
  display: flex;
  flex-direction: column;
  gap: 50px;
}

.settings_error {
  color: rgba(255, 0, 0, 0.51);
}

.settings_link img {
  width: 50px;
  height: 50px;
  object-fit: contain;
  flex-shrink: 0;
  filter: brightness(0) saturate(100%) invert(1);
}

.settings_link {
  display: flex;
  gap: 20px;
  align-items: center;
  min-width: 200px;
  max-width: 320px;
}
.settings_link p{
  display: -webkit-box;
  -webkit-line-clamp: 1;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
}
.contact_text {
  flex: 1;
  min-width: 0;
}
.settings_update {
  display: flex;
  flex-wrap: wrap;
  gap: 30px
}

.settings_overlay {
  display: flex;
  flex-wrap: wrap;
  gap: 20px 40px;
}

.settings_btn {
  display: flex;
  flex-wrap: wrap;
  gap: 15px;
  justify-content: space-between;
}

.settings_btn button {
  background: transparent;
  border: 1px solid #333;
  color: #aaa;
  padding: 10px;
  border-radius: 8px;
  cursor: pointer;
  font-size: 14px;
  transition: background-color .3s ease,
  color .3s ease,
  border-color .3s ease,
  transform .2s ease;
}

.settings_btn button:hover {
  background: #2a2a2a;
  color: #fff;
}

.settings_input input {
  margin-top: 5px;
  background: transparent;
  border: 1px solid #333;
  color: #aaa;
  padding: 10px;
  border-radius: 8px;
  font-size: 14px;
}
@media (max-width: 900px){
  .settings {
    display: flex;
    flex-direction: column;
    align-items: center;
  }
  .settings_btn{
    display: flex;
    flex-direction: column;
  }
  .settings_update {
    flex-direction: column;
    align-items: center;
  }
  .settings_overlay{
    gap: 20px;
    flex-direction: column;
  }
}
</style>