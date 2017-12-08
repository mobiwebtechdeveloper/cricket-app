import React, { Component } from 'react';
import Authentication from '../../containers/authentication';
import { Redirect } from 'react-router-dom';
import { Form, Text, Checkbox, StyledText } from 'react-form';
const Auth = new Authentication();
class Signup extends Component {
    constructor(props) {
        super(props);
        this.state = {};
    }

    componentWillMount = () =>{
        
    }

    errorValidator = (values) => {
        const validateUsername = (username) => {
            return !username  ? "Full Name is required."  : null;
        };

        return{
            username: validateUsername(values.username)
        };
    }

    warningValidator = (values) => {

    }

    successValidator = (values, errors) => {
        const validateUsername = () =>{
            return !errors.username ? 'Nice Name!' : null;
        };

        return{
            username: validateUsername(values.username)
        };
    }
    

    render() {
        if (Auth.loggedIn()) {
            return <Redirect to="/leagues" />
        }
        const SignUpForm = () => {
            return (
                <Form
                    validateWarning={this.warningValidator}
                    validateSuccess={this.successValidator}
                    validateError={this.errorValidator}
                    onSubmit={submittedValues => this.setState( { submittedValues } )}
                >
                    {formApi => (
                        <form onSubmit={formApi.submitForm} id="signUp">
                            <div className="signup_left">
                                <h3>Sign Up </h3>
                                <div className="form-group custom_input">
                                    <StyledText field="username" id="username"/>
                                    <label htmlFor="username">Full Name</label>
                                </div>
                                <div className="form-group custom_input">
                                    <StyledText field="email" id="email" />
                                    <label htmlFor="email">Email</label>
                                </div>
                                <div className="form-group custom_input">
                                    <StyledText field="password" id="password" />
                                    <label htmlFor="password">Password</label>
                                </div>
                                <div className="form-group custom_input">
                                    <StyledText field="cpassword" id="cpassword" />
                                    <label htmlFor="cpassword">Retupe Password</label>
                                </div>
                                <div className="form-group custom_input">
                                    <StyledText field="date_of_birth" id="date_of_birth" />
                                    <label htmlFor="date_of_birth">D.O.B</label>
                                </div>
                                <div className="form-group">
                                    <button type="submit" className="btn btn-submit">Sign Up</button>
                                </div>
                                <p className="text-center">
                                    Already have an account ? <a href="/">Sign In</a>
                                </p>
                            </div>
                        </form>
                    )}
                </Form>
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