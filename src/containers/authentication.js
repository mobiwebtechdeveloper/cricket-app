import React, { Component } from 'react';
const URL = "http://localhost/cricket-app";
class Authentication extends Component {
    constructor(props) {
        super(props);
        this.login = this.login.bind(this);
    }

    facebookAuth(response){
        let Url = URL+'/server/api/v1/user/socialSignIn';
        let stateData = {
            social_signup_type: "FACEBOOK",
            full_name: response.name,
            email:response.email,
            social_id: response.userID
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

    login(email, password) {
        let Url = URL+'/server/api/v1/user/isAuth';
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

    signUp(formData){
        let Url = URL+'/server/api/v1/user/signup';
        let stateData = {
            email: formData.email,
            signup_type:"WEB",
            full_name:formData.username,
            password:formData.password
            //date_of_birth:formData.date_of_birth
        };
        let option = { method: 'POST', body: JSON.stringify(stateData) };
        return this.fetch(Url,option)
        .then((res) =>{
            return Promise.resolve(res);
        });
        
    }

    setProfile(userResponse) {
        localStorage.setItem('profile', JSON.stringify(userResponse));
    }

    getProfile() {
        return localStorage.getItem('profile');
    }

    loggedIn() {
        const sessionToken = this.getToken();
        return !!sessionToken;
    }

    loggedOut(){
        localStorage.clear();
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