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
        console.warn("Obsolete method. Please use profileAPI object");
        return profileAPI.getProfile(userId);
    }
}

export const profileAPI = {
    getProfile(userId) {
        return instance.get(`profile/${userId}`);
    },
    getStatus(userId) {
        return instance.get(`profile/status/${userId}`);
    },
    updateStatus(status) {
        return instance.put(`profile/status`, {status: status});
    },
    savePhoto(file) {
        const formData = new FormData();
        formData.append('image', file);
        return instance.put(`profile/photo`, formData, {
            'Content-Type': 'multipart/form-data'
        });
    },
    saveProfile(profile) {
        return instance.put(`profile`, profile);
    }
}

export const authAPI = {
    me() {
        return instance.get('auth/me')
            .then(response => response.data);
    },
    login(email, password, rememberMe = false, captcha = null) {
        return instance.post('auth/login', {email, password, rememberMe, captcha})
            .then(response => response);
    },
    logout() {
        return instance.delete('auth/login')
            .then(response => response.data);
    }
}

export const securityAPI = {
    getCaptchaUrl() {
        return instance.get('security/get-captcha-url');
    }
}
