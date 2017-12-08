import React, { Component } from 'react';

class Authentication extends Component {
    constructor(props) {
        super(props);
        this.login = this.login.bind(this);
    }

    login(email, password) {
        let Url = 'http://localhost/cricket-app/server/api/v1/user/isAuth';
        let stateData = {
            email: email,
            password: password,
            signup_type:"WEB",
            redirectToReferrer: true
        }
        let option = { method: 'POST', body: JSON.stringify(stateData) };
        return this.fetch(Url, option)
            .then((res) => {
                if (res.status == 1) {  
                    this.setToken(res.response.login_session_key, res.response.id);
                    this.setProfile(res.response);
                }
                return Promise.resolve(res);
            });
    }

    setProfile(userResponse) {
        localStorage.setItem('profile', userResponse);
    }

    getProfile() {
        return localStorage.getItem('profile');
    }

    loggedIn() {
        const sessionToken = this.getToken();
        return !!sessionToken;
    }

    setToken(token, id) {
        localStorage.setItem('sessionToken', token);
        localStorage.setItem('userId', id);
    }

    getToken() {
        return localStorage.getItem('sessionToken');
    }

    userId() {
        return localStorage.getItem('userId');
    }

    fetch(url, option) {
        return new Promise((resolve, reject) => {
            fetch(url, option)
                .then((response) => response.json())
                .then((res) => {
                    resolve(res);
                })
                .catch((err) => {
                    reject(err);
                });
        });
    }
}

export default Authentication;