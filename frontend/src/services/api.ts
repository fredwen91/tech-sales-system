import axios from 'axios'
import type { AxiosError, AxiosInstance } from 'axios'

const api: AxiosInstance = axios.create({
  baseURL: import.meta.env.VITE_API_URL,
  headers: {
    Accept: 'application/json',
  },
})

/**
 * REQUEST INTERCEPTOR
 * Attach Sanctum token (Personal Access Token)
 */
api.interceptors.request.use((config) => {
  const token = localStorage.getItem('token')

  if (token && config.headers) {
    config.headers.Authorization = `Bearer ${token}`
  }

  return config
})

/**
 * RESPONSE INTERCEPTOR
 * If token is invalid/expired → logout user
 */
// api.interceptors.response.use(
//   (response) => response,
//   (error: AxiosError) => {
//     if (error.response?.status === 401) {
//       // Remove token
//       localStorage.removeItem("token");

//       // Optional: redirect to login
//       window.location.href = "/login";
//     }

//     return Promise.reject(error);
//   },
// );

export default api
