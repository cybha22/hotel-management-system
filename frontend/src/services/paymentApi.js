import api from './api'

export const paymentApi = {
    getAll: (rolePrefix = '/admin') => api.get(`${rolePrefix}/payments`),
    create: (data, rolePrefix = '/admin') => api.post(`${rolePrefix}/payments`, data),
    invoice: (id, rolePrefix = '/admin') => api.get(`${rolePrefix}/payments/${id}/invoice`),
}

export default paymentApi
