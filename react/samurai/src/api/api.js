import * as axios from 'axios';

const instance = axios.create({
    withCredentials: true,
    baseURL: 'https://social-network.samuraijs.com/api/1.0/',
    headers: {
        "API-KEY": "e8299a2b-8a8d-4411-9ad1-a439b2235435"
    }
});

export const usersAPI = {
    getUsers(currentPage = 1,pageSize = 10) {
        return instance.get(`users?page=${currentPage}&count=${pageSize}`)
            .then(response => response.data)
    },

    follow(userId) {
        return instance.post(`follow/${userId}`,{})
            .then(response => response.data)
    },

    unfollow(userId) {
        return instance.delete(`follow/${userId}`)
            .then(response => response.data)
    },

    getProfile(userId) {
        return instance.get(`profile/${userId}`);
    }
}

export const authAPI = {
    me() {
        return instance.get('auth/me')
            .then(response => response.data)
    }
}
