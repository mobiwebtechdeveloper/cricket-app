import React, { Component } from 'react';
import logo from '../../images/logo.png'
class Header extends Component{
    render(){
        return(
            <header className="header_sec" id="header">
              <div className="header_top">
                <div className="container-fluid">
                    <div className="header_top_left text-left"><i className="fa fa-star" aria-hidden="true"></i>
                      Lorem Ipsum is simply dummy text of the printing.</div>
                    <div className="header_top_right text-right">
                      <ul className="hdr_profile">
                        <li><a href="/">Verify Now</a></li>
                        <li><a href="/">Help</a></li>
                          
                          <li className="dropdown">
                              <a href="/" className="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> 
                                  micheal@testmail.com
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
                          </li>
                      </ul>
          
          
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
                        <div className="col-sm-9">
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
        
                      </div>
                    </div>
                  </div>
                
            </header>
     
        );
    }
}

export default Header;