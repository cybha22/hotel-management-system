import api from './api'

export const reservationApi = {
    getAll: (params = {}, rolePrefix = '/admin') => api.get(`${rolePrefix}/reservations`, { params }),
    get: (id, rolePrefix = '/admin') => api.get(`${rolePrefix}/reservations/${id}`),
    create: (data, rolePrefix = '/admin') => api.post(`${rolePrefix}/reservations`, data),
}

export default reservationApi
