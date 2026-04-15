import { defineStore } from 'pinia'
import api from '@/services/api'
import type { User } from '@/types/user'
import type { LoginPayload } from '@/types/auth'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null as User | null,
    token: null as string | null,
    loading: false,
    error: null as string | null,
    errors: {} as Record<string, string[]>,
  }),

  getters: {
    isAuthenticated(state) {
      return state.token && state.user
    },
  },

  actions: {
    async login(payload: LoginPayload): Promise<boolean> {
      this.loading = true
      this.error = null
      this.errors = {}

      try {
        const { data } = await api.post('auth/login', payload)

        localStorage.setItem('token', data.token)
        await this.fetchUser()

        return true
      } catch (error: any) {
        if (error.response.status === 401) {
          this.error = error.response.data.message
        } else if (error.response?.status === 422 && error.response.data?.errors) {
          this.errors = error.response.data.errors
        } else {
          alert('The system encountered an error. Please refresh the page.')
        }

        return false
      } finally {
        this.loading = false
      }
    },

    async fetchUser() {
      const token = localStorage.getItem('token')
      if (!token) return

      this.token = token
      try {
        const { data } = await api.get('auth/me')
        this.user = data
      } catch {
        this.logout()
      }
    },

    async logout() {
      try {
        await api.post('auth/logout')

        this.user = null
        this.token = null
        localStorage.removeItem('token')
      } catch (error: any) {
        if (error.response.status === 401) {
          this.user = null
          this.token = null
          localStorage.removeItem('token')
        } else {
          alert('The system encountered an error. Please refresh the page.')
        }
      }
    },
  },
})
