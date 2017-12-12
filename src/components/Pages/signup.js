
import React, { Component } from 'react';
import Authentication from '../../containers/authentication';
import { Redirect } from 'react-router-dom';
import TextField from 'material-ui/TextField';
import DatePicker from 'material-ui/DatePicker';
import RaisedButton from "material-ui/RaisedButton";
import { ValidatorForm } from 'react-form-validator-core';
import { TextValidator} from 'react-material-ui-form-validator';
import AlertContainer from 'react-alert';
const Auth = new Authentication();
const styles = {
    customWidth: {
        width: 450
    }
};
class Signup extends Component {
    constructor(props) {
        super(props);
        this.handleChange = this.handleChange.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
        this.state = {
            formData: {
                username:"",
                email:"",
                password:"",
                repeatPassword:""
            },
            submitted: false,
        };
    }

    componentWillMount(){
        ValidatorForm.addValidationRule('isPasswordMatch',(value) => {
            if(value !== this.state.formData.password){
                return false;
            }
            return true;
        });
    }

    handleChange (e){
        const { formData } = this.state;
        formData[e.target.name] =   e.target.value;
        this.setState({ formData });
    }

    handleSubmit(e) {
        this.setState({ submitted: true }, () => {
            setTimeout(() => this.setState({ submitted: false }), 5000);
        });
        Auth.signUp(this.state.formData)
        .then((res) => {
            if(res.status == 1){
                this.showAlert('success',res.message);
                setTimeout(() => this.props.history.push('/'), 3000);
            }else{
                this.showAlert('error',res.message);
                this.setState({ submitted: false });
            }
        });
    }
    alertOptions = {
        offset: 14,
        position: 'top right', // [bottom left, bottom right, top left, top right]
        theme: 'light',         // [dark, light] 
        time: 2000,
        transition: 'scale'    // [scale, fade]
    }
    showAlert = (type,message) => {
        if(type == 'success'){
         this.msg.success(message);
        }else if(type == 'error'){
            this.msg.error(message); 
        }else if(type == 'info'){
            this.msg.info(message); 
        } 
      }

    render() {
         const { formData, submitted } = this.state;
         if(Auth.loggedIn()){
            return <Redirect to="/leagues" />
        }
        return (
            <div className="main_container">
                <AlertContainer ref={a => this.msg = a} {...this.alertOptions} />
                <section className="main_content_sec signup_sec">
                    <div className="container">
                    <div className="signup_left">
                    <h3>Sign Up</h3>
                    <ValidatorForm onSubmit={this.handleSubmit}>
                        <div className="form-group custom_input">
                            <TextValidator 
                                type="text" hintText="Name Field"
                                floatingLabelText="Full Name" 
                                name="username"
                                style={styles.customWidth}
                                onChange={this.handleChange} 
                                value={formData.username}
                                validators={['required']}
                                errorMessages={['Full Name field is required']}/>
                        </div>
                        <div className="form-group custom_input">
                            <TextValidator type="email" name="email"
                                hintText="example@domain.com"
                                floatingLabelText="Email" style={styles.customWidth} 
                                value={formData.email}
                                onChange={this.handleChange} 
                                validators={['required', 'isEmail']}
                                errorMessages={['Email field is required', 'email is not valid']}/>
                        </div>
                        <div className="form-group custom_input">
                            <TextValidator type="password" name="password"
                                hintText="password" floatingLabelText="Password" style={styles.customWidth} 
                                value={formData.password}
                                validators={['required']}
                                onChange={this.handleChange} 
                                errorMessages={['Password field is required']}/>
                        </div>
                        <div className="form-group custom_input">
                        <TextValidator
                                floatingLabelText="Repeat password"
                                onChange={this.handleChange}
                                name="repeatPassword"
                                type="password"
                                validators={['isPasswordMatch', 'required']}
                                errorMessages={['password mismatch', 'this field is required']}
                                value={formData.repeatPassword}
                                style={styles.customWidth}
                            />
                        </div>
                        <div className="form-group custom_input">
                            <DatePicker hintText="Date Of Birth"
                                openToYearSelection={true} ref="date_of_birth"
                                errorText={this.state.date_of_birthErr}
                                />
                        </div>
                        <br></br>
                        <div className="form-group">
                            <label>
                                <input type="checkbox" /> I agree to Brand Name <a href="/">T&C</a>
                            </label>
                        </div>
                        <div className="form-group">
                            <RaisedButton
                                    type="submit"
                                    label={
                                        (submitted && 'Your form is submitted!') ||
                                        (!submitted && 'Sign Up')
                                    }
                                    className="btn btn-submit"
                                    disabled={submitted}
                                    primary={true}
                                />
                        </div>
                    </ValidatorForm>
                    <p className="text-center">
                        Already have an account ? <a href="/">Sign In</a>

                    </p>
                </div>
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