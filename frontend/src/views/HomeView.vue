<script setup>
import HeroSection from '@/components/home/HeroSection.vue'

import AboutSection from '@/components/home/AboutSection.vue'

import CategoriesSection from '@/components/home/CategoriesSection.vue'

import ReviewsSection from '@/components/home/ReviewsSection.vue'

import ContactsSection from '@/components/home/ContactsSection.vue'
import FloatingContactButton from "@/components/additional/FloatingContactButton.vue";
</script>

<template>
  <FloatingContactButton />
  <HeroSection />
  <AboutSection />
  <CategoriesSection />
  <ReviewsSection />
  <ContactsSection />
</template>
