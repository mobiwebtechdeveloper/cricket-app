import React, { Component } from 'react';
import Authentication from '../../containers/authentication';
import logo from '../../images/logo.png'
import { Redirect } from 'react-router-dom';
const Auth = new Authentication();
class Header extends Component {
    constructor(props) {
        super(props);
        this.state = { users: this.props.profile, open: false, redirect: false };
    }

    handleRequestClose = () => {
        this.setState({
            open: false,
        });
    }

    authLogout = () => {
        Auth.loggedOut();
        this.setState({
            redirect: true,
        });

    }

    render() {
        let series = "";
        let headerUserProfile = "";
        const { redirect } = this.state;
        let name = "";
        if(this.state.users){
             name = this.state.users.name+" ("+this.state.users.team_code+")"
        }
        if (redirect) {
            return <Redirect to='/' />;
        }
        if (Auth.loggedIn()) {
            series = <div className="col-sm-9">
                <div className="bottom_header_right text-right">
                    <div className="top_search">
                        <select className="top_select">
                            <option>All Series</option>
                            <option>All Series</option>
                            <option>All Series</option>
                        </select>
                    </div>
                    <div className="top_ruppe"> <span className="flaticon-wallet"></span>
                        RS. 0 <a href="/"><i className="fa fa-plus-circle" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>;

        }
        if (Auth.loggedIn()) {
            headerUserProfile = <ul className="hdr_profile">
                <li><a href="/">Verify Now</a></li>
                <li><a href="/" onClick={this.authLogout}><i className="fa fa-fw fa-power-off"></i> Log Out</a></li>
                <li className="dropdown">
                    <a href="/" className="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                      {name}
          <i className="fa fa-angle-down"></i>
                    </a>
                    
                    <ul className="dropdown-menu">
                        <li>
                            <a href="javascript:void(0)" data-toggle="modal" data-target="/edit_profile"><i className="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li>
                            <a href="/"><i className="fa fa-fw fa-envelope"></i> Inbox</a>
                        </li>
                        <li>
                            <a href="/"><i className="fa fa-fw fa-gear"></i> Settings</a>
                        </li>
                        <li>
                            <a href="/"><i className="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
                <li className="dropdown dd_notification">
                    <a href="/" className="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <i className="flaticon-notification"></i> <span className="badge">3</span>
                    </a>
                    <ul className="dropdown-menu alert-dropdown">
                        <li>
                            <a href="/">Alert Name <span className="label label-default">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="/">Alert Name <span className="label label-primary">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="/">Alert Name <span className="label label-success">Alert Badge</span></a>
                        </li>

                    </ul>
                </li></ul>
        } else {
            headerUserProfile = <ul className="hdr_profile">
                <li><a href="/">Help</a></li></ul>;
        }
        return (
            <header className="header_sec" id="header">
                <div className="header_top">
                    <div className="container-fluid">
                        <div className="header_top_left text-left"><i className="fa fa-star" aria-hidden="true"></i>
                            Official Fantasy Cricket Partner of Hero CPL T20 2017!</div>
                        <div className="header_top_right text-right">

                            {headerUserProfile}

                        </div>
                    </div>
                </div>
                <div className="container-fluid">
                    <div className="row">
                        <div className="col-sm-3">
                            <div className="logo">
                                <a href="/"><img src={logo} className="img-responsive" alt="logo" /> </a>
                            </div>
                        </div>

                        {series}

                    </div>
                </div>

            </header>

        );
    }
}

export default Header;