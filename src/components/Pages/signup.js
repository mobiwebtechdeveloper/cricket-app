
import React, { Component } from 'react';
import Authentication from '../../containers/authentication';
import { Redirect } from 'react-router-dom';
const Auth = new Authentication();
class Signup extends Component {
    constructor(props) {
        super(props);
        this.state = {};
    }

    handleSubmit = (event) => {
        event.preventDefault();
        console.log(event);
    };

    render() {
        const SignUpForm = () => {
            return (
                <div className="signup_left">
                    <h3>Sign Up</h3>
                    <div className="form-group custom_input">
                        <input type="text" />
                        <label>Username</label>
                    </div>
                    <div className="form-group custom_input">
                        <input 
                            type="email"
                            name="email"/>
                        <label>Email</label>
                    </div>
                    <div className="form-group custom_input">
                        <input type="password" />
                        <label>Password</label>
                    </div>
                    <div className="form-group custom_input">
                        <input type="password" />
                        <label>Retupe Password</label>
                    </div>
                    <div className="form-group custom_input">
                        <input type="text" />
                        <label>D.O.B</label>
                    </div>
                    <div className="form-group">
                        <label>
                            <input type="checkbox" /> I agree to Brand Name <a href="/">T&C</a>
                        </label>
                    </div>
                    <div className="form-group">
                        <button type="submit" className="btn btn-submit">Sign Up</button>
                    </div>
                    <p className="text-center">
                        Already have an account ? <a href="/">Sign In</a>

                    </p>
                </div>
            );
        }

        return (
            <div className="main_container">
                <section className="main_content_sec signup_sec">
                    <div className="container">
                        <SignUpForm />
                        <div className="or_box">OR</div>
                        <div className="signup_right">
                            <h3>Connect instantly <br></br> with</h3>
                            <a href="/">Log in with facebook</a>
                            <a href="/" className="google_sign">Log in with Google +</a>
                        </div>
                    </div>

                </section>
            </div>
        );
    }

}

export default Signup;