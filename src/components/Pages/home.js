import React, { Component } from 'react';
import Slider from 'react-slick';
import Authentication from '../../containers/authentication';
import { Redirect } from 'react-router-dom';
import Countdown from 'react-countdown-now';
import Moment from 'moment';
import MatchList from './match';
const Auth = new Authentication();
const URL = "http://localhost/cricket-app";
class Home extends Component {

  constructor(props) {
    super(props);
    this.state = { MegaContest:[] };
    this.getMegaContest = this.getMegaContest.bind(this);

  }

  getInitialState() {
    return { MegaContest:[] };
  }

  componentWillMount = () => {
    this.getMegaContest(localStorage.getItem('matchId'));
  }


  getMegaContest = (matchId) => {
    let Url = URL + '/server/api/v1/contest/mega_contests';
    let stateData = { 
      login_session_key: Auth.getToken(),
      user_id : Auth.userId(),
      match_id: matchId
     };
    let option = { method: 'POST', body: JSON.stringify(stateData) };
    Auth.fetch(Url, option)
    .then((res) => {
      this.setState({ MegaContest: res.response });
    });
  }

  viewMegaContest = () => {
    if(this.state.MegaContest.length > 0){
    var MegaContest = this.state.MegaContest.map(function (contests) {
      return     <div className="match_left_box" key={contests.contest_name}>
      <div className="match_left_header">Mega Contest <span>{contests.contest_name}</span></div>
      <div className="match_left_body">
        <h4>Win Rs.{contests.total_winning_amount}</h4>
        <div className="progress">
          <div className="progress-bar progress-bar-warning progress-bar-striped" role="progressbar"
            aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
            60% Complete (warning)
                </div>
        </div>
  
        <div className="progress_footer">
          <h4>0/{contests.contest_size}
            {(contests.confirm_contest) ? <a href="/">C</a> : "" } 
            {(contests.mega_contest) ? <a href="/">m</a> : "" } 
          </h4> <button data-toggle="modal" data-target="#mega_contest" className="btn btn-submit">Join</button>
        </div>
  
      </div>
    </div>
    });
  return(
    <div>{MegaContest}</div>
  );
  }else{
    return(
      <div>Mega Contest</div>
    );
  }
  }

  render() {
    if (!Auth.loggedIn()) {
      return <Redirect to="/" />
    }
    return (
      <div className="main_container">
        <section className="main_content_sec">
          <div className="container-fluid">
            <div className="content_wrap">
              <div className="events_list_slider_main">
                <MatchList />
              </div>
              <div className="match_section">
                <div className="row">
                  <div className="col-sm-4">
                    <div className="match_left">
                      {this.viewMegaContest()}
                      <div className="match_left_box">
                        <div className="match_left_header">Invite Friends <span>Pay Rs. 33</span></div>
                        <div className="match_left_body">
                          <div className="progress_footer">
                            <h4>Invite your friends</h4> <button className="btn btn-submit">Invite Friends</button>
                          </div>
                        </div>
                      </div>
                      <div className="match_left_box">
                        <div className="match_left_header">Invite Friends <span>Pay Rs. 33</span></div>
                        <div className="match_left_body">
                          <div className="progress_footer">
                            <input type="text" placeholder="Enter Contest Code" /> <button className="btn btn-submit">Join</button> <button className="btn btn-submit creat-btn" data-toggle="modal" data-target="#creat_contest">Create a Contest</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div className="col-sm-8">
                    <div className="match_ground">
                      <div className="match_ground_header text-right"> <button className="btn btn-submit">Add Team 1</button></div>
                      <div className="match_ground_body">
                        <ul className="cross_player">
                          <li>
                            <div className="player_img">
                              <img src="images/rohit.png" className="img-responsive" />
                            </div>
                            <a href="/" className="player_cross">X</a>
                            <h4>Rohit Sharma</h4><span>Points : 11.5</span>
                          </li>
                          <li>
                            <div className="player_img">
                              <img src="images/rohit.png" className="img-responsive" />
                            </div>
                            <a href="/" className="player_cross">X</a>
                            <h4>Rohit Sharma</h4><span>Points : 11.5</span>
                          </li>
                          <li>
                            <div className="player_img">
                              <img src="images/rohit.png" className="img-responsive" />
                            </div>
                            <a href="/" className="player_cross">X</a>
                            <h4>Rohit Sharma</h4><span>Points : 11.5</span>
                          </li>
                        </ul>
                        <ul className="add_player">
                          <li>
                            <div className="player_img">
                              <img src="images/add_player.png" className="img-responsive" />
                            </div>
                            <a href="/" className="player_cross">+</a>
                            <h4>Player Name</h4><span>Points : 00</span>
                          </li>
                          <li>
                            <div className="player_img">
                              <img src="images/add_player.png" className="img-responsive" />
                            </div>
                            <a href="/" className="player_cross">+</a>
                            <h4>Player Name</h4><span>Points : 00</span>
                          </li>
                          <li>
                            <div className="player_img">
                              <img src="images/add_player.png" className="img-responsive" />
                            </div>
                            <a href="/" className="player_cross">+</a>
                            <h4>Player Name</h4><span>Points : 00</span>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div className="progress_sec">
                <ul className="nav nav-tabs">
                  <li className="active"><a data-toggle="tab" href="#public">Public</a></li>
                  <li><a data-toggle="tab" href="#contest">My Contest</a></li>
                </ul>

                <div className="tab-content">
                  <div id="public" className="tab-pane fade in active">
                    <div className="tab_sarch">
                      <ul className="clearfix">
                        <li>
                          <label>Win (Rs.)</label>
                          <select className="form-control">
                            <option>All</option>
                            <option>All</option>
                            <option>All</option>
                          </select>
                        </li>
                        <li>
                          <label>Pay (Rs.)</label>
                          <select className="form-control">
                            <option>All</option>
                            <option>All</option>
                            <option>All</option>
                          </select>
                        </li>
                        <li>
                          <label>Size (Teams)</label>
                          <select className="form-control">
                            <option>All</option>
                            <option>All</option>
                            <option>All</option>
                          </select>
                        </li>
                        <li className="text-right">
                          <label></label>
                          <button className="btn btn-submit btn-search">Reset</button>
                        </li>
                      </ul>
                    </div>
                    <div className="public_progres clearfix">
                      <div className="match_left_box">
                        <div className="match_left_header">Win Rs 20,00,000</div>
                        <div className="match_left_body">
                          <h4>Play Rs.10 <span>1/3 Teams</span></h4>
                          <div className="progress">
                            <div className="progress-bar progress-bar-warning progress-bar-striped" role="progressbar"
                              aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                              60% Complete (warning)
                                        </div>
                          </div>

                          <div className="progress_footer">
                            <h4><i className="flaticon-crown"></i> 754692 Winners </h4> <button className="btn btn-submit">Join</button>
                          </div>

                        </div>
                      </div>
                      <div className="match_left_box">
                        <div className="match_left_header">Win Rs 20,00,000</div>
                        <div className="match_left_body">
                          <h4>Play Rs.10 <span>1/3 Teams</span></h4>
                          <div className="progress">
                            <div className="progress-bar progress-bar-warning progress-bar-striped" role="progressbar"
                              aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                              60% Complete (warning)
                                          </div>
                          </div>

                          <div className="progress_footer">
                            <h4><i className="flaticon-crown"></i> 754692 Winners </h4> <button className="btn btn-submit">Join</button>
                          </div>

                        </div>
                      </div>
                      <div className="match_left_box">
                        <div className="match_left_header">Win Rs 20,00,000</div>
                        <div className="match_left_body">
                          <h4>Play Rs.10 <span>1/3 Teams</span></h4>
                          <div className="progress">
                            <div className="progress-bar progress-bar-warning progress-bar-striped" role="progressbar"
                              aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                              60% Complete (warning)
                                            </div>
                          </div>

                          <div className="progress_footer">
                            <h4><i className="flaticon-crown"></i> 754692 Winners </h4> <button className="btn btn-submit">Join</button>
                          </div>

                        </div>
                      </div>
                      <div className="match_left_box">
                        <div className="match_left_header">Win Rs 20,00,000</div>
                        <div className="match_left_body">
                          <h4>Play Rs.10 <span>1/3 Teams</span></h4>
                          <div className="progress">
                            <div className="progress-bar progress-bar-warning progress-bar-striped" role="progressbar"
                              aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                              60% Complete (warning)
                                              </div>
                          </div>

                          <div className="progress_footer">
                            <h4><i className="flaticon-crown"></i> 754692 Winners </h4> <button className="btn btn-submit">Join</button>
                          </div>

                        </div>
                      </div>
                      <div className="match_left_box">
                        <div className="match_left_header">Win Rs 20,00,000</div>
                        <div className="match_left_body">
                          <h4>Play Rs.10 <span>1/3 Teams</span></h4>
                          <div className="progress">
                            <div className="progress-bar progress-bar-warning progress-bar-striped" role="progressbar"
                              aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                              60% Complete (warning)
                                                </div>
                          </div>

                          <div className="progress_footer">
                            <h4><i className="flaticon-crown"></i> 754692 Winners </h4> <button className="btn btn-submit">Join</button>
                          </div>

                        </div>
                      </div>
                      <div className="match_left_box">
                        <div className="match_left_header">Win Rs 20,00,000</div>
                        <div className="match_left_body">
                          <h4>Play Rs.10 <span>1/3 Teams</span></h4>
                          <div className="progress">
                            <div className="progress-bar progress-bar-warning progress-bar-striped" role="progressbar"
                              aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                              60% Complete (warning)
                                                  </div>
                          </div>

                          <div className="progress_footer">
                            <h4><i className="flaticon-crown"></i> 754692 Winners </h4> <button className="btn btn-submit">Join</button>
                          </div>

                        </div>
                      </div>
                      <div className="match_left_box">
                        <div className="match_left_header">Win Rs 20,00,000</div>
                        <div className="match_left_body">
                          <h4>Play Rs.10 <span>1/3 Teams</span></h4>
                          <div className="progress">
                            <div className="progress-bar progress-bar-warning progress-bar-striped" role="progressbar"
                              aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                              60% Complete (warning)
                                                    </div>
                          </div>

                          <div className="progress_footer">
                            <h4><i className="flaticon-crown"></i> 754692 Winners </h4> <button className="btn btn-submit">Join</button>
                          </div>

                        </div>
                      </div>
                      <div className="match_left_box">
                        <div className="match_left_header">Win Rs 20,00,000</div>
                        <div className="match_left_body">
                          <h4>Play Rs.10 <span>1/3 Teams</span></h4>
                          <div className="progress">
                            <div className="progress-bar progress-bar-warning progress-bar-striped" role="progressbar"
                              aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                              60% Complete (warning)
                                                      </div>
                          </div>

                          <div className="progress_footer">
                            <h4><i className="flaticon-crown"></i> 754692 Winners </h4> <button className="btn btn-submit">Join</button>
                          </div>

                        </div>
                      </div>
                      <div className="match_left_box">
                        <div className="match_left_header">Win Rs 20,00,000</div>
                        <div className="match_left_body">
                          <h4>Play Rs.10 <span>1/3 Teams</span></h4>
                          <div className="progress">
                            <div className="progress-bar progress-bar-warning progress-bar-striped" role="progressbar"
                              aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                              60% Complete (warning)
                                                        </div>
                          </div>

                          <div className="progress_footer">
                            <h4><i className="flaticon-crown"></i> 754692 Winners </h4> <button className="btn btn-submit">Join</button>
                          </div>

                        </div>
                      </div>
                      <div className="match_left_box">
                        <div className="match_left_header">Win Rs 20,00,000</div>
                        <div className="match_left_body">
                          <h4>Play Rs.10 <span>1/3 Teams</span></h4>
                          <div className="progress">
                            <div className="progress-bar progress-bar-warning progress-bar-striped" role="progressbar"
                              aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                              60% Complete (warning)
                                                          </div>
                          </div>

                          <div className="progress_footer">
                            <h4><i className="flaticon-crown"></i> 754692 Winners </h4> <button className="btn btn-submit">Join</button>
                          </div>

                        </div>
                      </div>
                      <div className="match_left_box">
                        <div className="match_left_header">Win Rs 20,00,000</div>
                        <div className="match_left_body">
                          <h4>Play Rs.10 <span>1/3 Teams</span></h4>
                          <div className="progress">
                            <div className="progress-bar progress-bar-warning progress-bar-striped" role="progressbar"
                              aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                              60% Complete (warning)
                                                            </div>
                          </div>

                          <div className="progress_footer">
                            <h4><i className="flaticon-crown"></i> 754692 Winners </h4> <button className="btn btn-submit">Join</button>
                          </div>

                        </div>
                      </div>
                      <div className="match_left_box">
                        <div className="match_left_header">Win Rs 20,00,000</div>
                        <div className="match_left_body">
                          <h4>Play Rs.10 <span>1/3 Teams</span></h4>
                          <div className="progress">
                            <div className="progress-bar progress-bar-warning progress-bar-striped" role="progressbar"
                              aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" >
                              60% Complete (warning)
                                                              </div>
                          </div>

                          <div className="progress_footer">
                            <h4><i className="flaticon-crown"></i> 754692 Winners </h4> <button className="btn btn-submit">Join</button>
                          </div>

                        </div>
                      </div>
                      <div className="match_left_box">
                        <div className="match_left_header">Win Rs 20,00,000</div>
                        <div className="match_left_body">
                          <h4>Play Rs.10 <span>1/3 Teams</span></h4>
                          <div className="progress">
                            <div className="progress-bar progress-bar-warning progress-bar-striped" role="progressbar"
                              aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" >
                              60% Complete (warning)
                                                                </div>
                          </div>

                          <div className="progress_footer">
                            <h4><i className="flaticon-crown"></i> 754692 Winners </h4> <button className="btn btn-submit">Join</button>
                          </div>

                        </div>
                      </div>
                      <div className="match_left_box">
                        <div className="match_left_header">Win Rs 20,00,000</div>
                        <div className="match_left_body">
                          <h4>Play Rs.10 <span>1/3 Teams</span></h4>
                          <div className="progress">
                            <div className="progress-bar progress-bar-warning progress-bar-striped" role="progressbar"
                              aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" >
                              60% Complete (warning)
                                                                  </div>
                          </div>

                          <div className="progress_footer">
                            <h4><i className="flaticon-crown"></i> 754692 Winners </h4> <button className="btn btn-submit">Join</button>
                          </div>

                        </div>
                      </div>
                      <div className="match_left_box">
                        <div className="match_left_header">Win Rs 20,00,000</div>
                        <div className="match_left_body">
                          <h4>Play Rs.10 <span>1/3 Teams</span></h4>
                          <div className="progress">
                            <div className="progress-bar progress-bar-warning progress-bar-striped" role="progressbar"
                              aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" >
                              60% Complete (warning)
                                                                    </div>
                          </div>

                          <div className="progress_footer">
                            <h4><i className="flaticon-crown"></i> 754692 Winners </h4> <button className="btn btn-submit">Join</button>
                          </div>

                        </div>
                      </div>
                      <div className="match_left_box">
                        <div className="match_left_header">Win Rs 20,00,000</div>
                        <div className="match_left_body">
                          <h4>Play Rs.10 <span>1/3 Teams</span></h4>
                          <div className="progress">
                            <div className="progress-bar progress-bar-warning progress-bar-striped" role="progressbar"
                              aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" >
                              60% Complete (warning)
                                                                      </div>
                          </div>

                          <div className="progress_footer">
                            <h4><i className="flaticon-crown"></i> 754692 Winners </h4> <button className="btn btn-submit">Join</button>
                          </div>

                        </div>
                      </div>
                    </div>
                  </div>
                  <div id="contest" className="tab-pane fade">
                    <h3>Menu 1</h3>
                    <p>Some content in menu 1.</p>
                  </div>
                </div>
              </div>



            </div>
          </div>
        </section>
      </div>

    );
  }
}

export default Home;