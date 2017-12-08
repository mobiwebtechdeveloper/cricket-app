import React, { Component } from 'react';
import Header from './components/Header/header';
import Footer from './components/Footer/footer';
import Home from './components/Pages/home';
import Signin from './components/Pages/signin';
import Signup from './components/Pages/signup';
import Authentication from './containers/authentication';
import './css/custom.css';
import {
  BrowserRouter,
  Route,
  Link,
  Switch,
  Redirect
} from 'react-router-dom';
const Auth = new Authentication();
class App extends Component {
  render() {
    return (
      <div className="App">
        <Header />
            <Switch>
            <Route exact path='/' component={Signin}/>
            <Route exact path='/signup' component={Signup}/>
            <Route exact path="/leagues" component={Home}/>
            </Switch>
        <Footer />
      </div>
    );
  }
}

export default App;
