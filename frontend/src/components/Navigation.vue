<script setup lang="ts">
import { ref } from 'vue'
import { useAuthStore } from '@/stores/auth'
import { useRouter } from 'vue-router'
import LogoutDialog from '@/components/LogoutDialog.vue'

const { logout } = useAuthStore()
const router = useRouter()

const drawer = ref(true)
const showLogout = ref(false)

const onLogout = async () => {
  showLogout.value = true

  await logout()
  router.push({ name: 'login' })
  showLogout.value = false
}
</script>

<template>
  <v-navigation-drawer v-model="drawer">
    <template v-slot:prepend>
      <v-list-item lines="two" title="EXAM" subtitle="DSI TECHNOLOGY"></v-list-item>
    </template>

    <v-divider></v-divider>

    <v-list nav>
      <v-list-item
        prepend-icon="mdi-view-dashboard"
        title="Dashboard"
        value="dashboard"
        color="primary"
        :to="{ name: 'dashboard' }"
      ></v-list-item>
      <v-list-item
        prepend-icon="mdi-logout"
        title="Logout"
        value="logout"
        color="primary"
        @click="onLogout"
      ></v-list-item>
    </v-list>
  </v-navigation-drawer>

  <v-app-bar :elevation="2">
    <template v-slot:prepend>
      <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
    </template>
  </v-app-bar>

  <LogoutDialog v-model="showLogout" />
</template>
