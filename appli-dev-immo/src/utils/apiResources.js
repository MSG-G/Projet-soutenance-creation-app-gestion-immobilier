import api from './api';

// Factory pour créer une ressource API CRUD complète
const createApiResource = (resource) => ({
  list: () => api.get(`/${resource}`),
  get: (id) => api.get(`/${resource}/${id}`),
  create: (data) => api.post(`/${resource}`, data),
  update: (id, data) => api.put(`/${resource}/${id}`, data),
  remove: (id) => api.delete(`/${resource}/${id}`),
  search: (query) => api.get(`/${resource}/search?query=${encodeURIComponent(query)}`),
});

export const biensApi = createApiResource('biens');
export const proprietairesApi = createApiResource('proprietaires');
export const reservationsApi = createApiResource('reservations');
export const contratsApi = createApiResource('contrats');

// API spécifique pour les utilisateurs avec des rôles
export const usersApi = {
  ...createApiResource('users'),
  listClients: () => api.get('/users/role/client'),
  listAgents: () => api.get('/users/role/agent'),
};

// API spécifique pour les photos
export const photosApi = {
  add: (formData) => api.post('/photos', formData, { headers: { 'Content-Type': 'multipart/form-data' } }),
  remove: (id) => api.delete(`/photos/${id}`),
};

// API spécifique pour les notifications
export const notificationsApi = {
  list: () => api.get('/notifications'),
  markRead: (id) => api.put(`/notifications/${id}/read`),
};

// API spécifique pour les messages
export const messagesApi = {
  list: () => api.get('/messages'),
  send: (data) => api.post('/messages', data),
  remove: (id) => api.delete(`/messages/${id}`),
};