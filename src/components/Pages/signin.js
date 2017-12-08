import React, { Component } from 'react';
import validator from 'validator';
import Authentication from '../../containers/authentication';
import { Redirect } from 'react-router-dom';
const Auth = new Authentication();
class Signin extends Component {

    constructor(props){
        super(props);
        this.handleSubmit = this.handleSubmit.bind(this);
        this.handleChange = this.handleChange.bind(this);
        this.state = {email:"",password:"",error:"",authFails:false};
    }

    handleChange(e){
        this.setState ({
            email:this.refs.email.value,
            password:this.refs.password.value
        });
    }

    handleSubmit(e){
        e.preventDefault();
        if(this.state.email == "" 
        && this.state.password == ""){
            this.setState({error:"Email and Password field is required"});
        }else{
            Auth.login(this.state.email,this.state.password)
            .then((res) =>{
                 if(!res.status){
                    this.setState({error:res.message});
                 }else{
                    this.props.history.push('/leagues'); 
                }
            });
           
        }

        
    }

    render() {
        if(Auth.loggedIn()){
            return <Redirect to="/leagues" />
        }
        return (
            <div className="main_container">
                <section className="main_content_sec signup_sec">
                    <div className="container">
                        <div className="signup_left">
                            <form onSubmit={this.handleSubmit}>
                            <h3>Sign In</h3>
                            
                            {(this.state.error) ? <div className="text-danger">{this.state.error}</div> : ""}
                            <div className="form-group custom_input">
                                <input type="text" ref="email" value={this.state.email} onChange={this.handleChange}/>
                                <label>Email</label>
                            </div>
                            <div className="form-group custom_input">
                                <input type="password" ref="password" value={this.state.password} onChange={this.handleChange}/>
                                <label>Password</label>
                            </div>
                            <div className="form-group">
                                <label>
                                    <input type="checkbox" /> Remember Me
                                    </label>
                                <a href="/" className="forgot_pswrd">Forgot Password</a>
                            </div>
                            <div className="form-group">
                                <button type="submit" className="btn btn-submit">Sign In</button>
                            </div>
                            <p className="text-center">
                                Dont’s have an account ?   <a href="/signup">Sign Up</a>
                            </p>
                            </form>
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

export default Signin;