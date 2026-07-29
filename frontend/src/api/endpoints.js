import api from './axios';

export const auth = {
    login: (credentials) => api.post('/login', credentials),
    logout: () => api.get('/logout'),
    info: () => api.get('/info'),
}

export const reviews = {
    getPublic: () => api.get('/review'),
    create: (data) => api.post('/review', data),
    getAll: (params) => api.get('/review/all', {params}),
    update: (id, data) => api.patch(`/review/${id}`, data),
    delete: (id) => api.delete(`/review/${id}`),
};

export const categories = {
    getPublic: () => api.get('/category'),
    getAll: () => api.get('/category/all'),
    create: (data) => api.post('/category', data),
    update: (id, data) => api.patch(`/category/${id}`, data),
    delete: (id) => api.delete(`/category/${id}`),
};

export const projects = {
    getByCategory: (categorySlug, params = {}) => api.get(`/project/${categorySlug}`, {params}),
    create: (categoryId, data) => api.post(`/project/${categoryId}`, data),
    update: (id, data) => api.patch(`/project/${id}`, data),
    delete: (id) => api.delete(`/project/${id}`),
    addMedia: (projectId, data) => api.post(`/project/${projectId}/media`, data),
    deleteMedia: (mediaId) => api.delete(`/project/media/${mediaId}`),
    getMedia: (projectId) => api.get(`/project/media/${projectId}`),
};

export const settings = {
    get: () => api.get('/settings'),
    update: (data) => api.post('/settings', data),
};