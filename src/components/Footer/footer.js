import React, { Component } from 'react';
import footerLogo from '../../images/footer-logo.png';
class Footer extends Component{
    render(){
        return(
            <footer id="footer" className="footer_sec">
            <div className="container-fluid">
              <div className="row">
                <div className="col-sm-3">
                    <div className="footr_menu">
                        <ul>
                          <li><i className="fa fa-map-marker" aria-hidden="true"></i>
                            Lorem Ipsum is simply dummy text 
                              of, NC 27101</li>
                          <li><i className="fa fa-phone" aria-hidden="true"></i>
                            336-760-9331</li>
                          <li><i className="fa fa-envelope" aria-hidden="true"></i>
                            Info@brandname.com</li>
                         
                        </ul>
                      </div>
                </div>
                <div className="col-sm-2">
                    <div className="footr_menu">
                      <ul>
                        <li><a href="/">About Us</a></li>
                        <li><a href="/"> Contact Us</a></li>
                        <li><a href="/"> Work with Us </a></li>
                        <li><a href="/">SkillUp</a></li>
                        <li><a href="/">Forum</a></li>
                      </ul>
                    </div>
                  </div>
                <div className="col-sm-3">
                  <div className="footr_menu">
                    <ul>
                      <li><a href="/">How to Play Fantasy Cricket</a></li>
                      <li><a href="/">Fantasy Points System</a></li>
                      <li><a href="/">Fantasy Cricket Contests</a></li>
                      <li><a href="/">Cricket Live Scores</a></li>
                      <li><a href="/">Cricket Match Results</a></li>
                    </ul>
                  </div>
                </div>
                <div className="col-sm-2">
                    <div className="footr_menu">
                      <ul>
                        <li><a href="/">FAQs</a></li>
                        <li><a href="/">FairPlay</a></li>
                        <li><a href="/">Brand Name Foundation</a></li>
                        <li><a href="/">Fantasy Cricket Legalities</a></li>
                        <li><a href="/">Testimonials</a></li>
                      </ul>
                    </div>
                  </div>
                  <div className="col-sm-2">
                      <div className="social_menu">
                          <ul >
                              <li><a href="/"><i className="fa fa-facebook"></i></a></li>
                              <li><a href="/"><i className="fa fa-twitter"></i></a></li>
                              <li><a href="/"><i className="fa fa-linkedin"></i></a></li>
                              <li><a href="/"><i className="fa fa-vimeo"></i></a></li>
                            </ul>
                      </div>
                    </div>
              </div>
            </div>
            <div className="footer_bottom">
              <div className="container-fluid">
                <div className="">
                  <div className="col-sm-6">
                    <div className="footer_left">
                      <div className="footer_logo">
                        <a href="/"><img src={footerLogo} className="img-responsive" /></a>
                      </div>
                      <div className="copyright">Copyright © Brand Name. All rights reserved.</div>
                    </div>
                  </div>
                  <div className="col-sm-6">
                    <div className="footer_right text-right">
                      <ul>
                        <li><a href="/">Privacy Policy</a> </li>
                        <li><a href="/">Terms & Conditions</a> </li>
                        <li><a href="/">Sitemap</a> </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
              
          </footer>
        );
    }
}

export default Footer;