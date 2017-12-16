import React, { Component } from 'react';
import Slider from 'react-slick';
import Countdown from 'react-countdown-now';
import Moment from 'moment';
import Authentication from '../../containers/authentication';
const URL = "http://localhost/cricket-app";
const Auth = new Authentication();
class Match extends Component {
    constructor(props) {
        super(props);
        this.state = { match: [] };
        this.getMatchList = this.getMatchList.bind(this);
        this.matchList = this.matchList.bind(this);
        this.setMatchSession = this.setMatchSession.bind(this);
        this.isMatchCheckClosed = this.isMatchCheckClosed.bind(this);
    }

    componentWillMount = () => {
        this.getMatchList();
    }

    getInitialState() {
        return { match: [] };
    }
    /* 
        @method: countDownStart
        @var: PrDate,PreTime
        @description: to start count down match start
    */
    countDownStart = (PrDate, PreTime) => {
        var startDate = new Date();
        var endDate = new Date(PrDate + " " + PreTime + ":00");
        var seconds = (endDate.getTime() - startDate.getTime());
        if (seconds > 0) {
            return (
                <div>
                    <Countdown daysInHours={true} date={Date.now() + seconds}></Countdown></div>
            );
        } else {
            return (
                <div>Closed</div>
            );
        }
    }
    /* 
        @method: isMatchCheckClosed
        @var: PrDate,PreTime,matchId
        @description: to check match open or closed
    */
    isMatchCheckClosed = (PrDate, PreTime, matchId) => {
        var startDate = new Date();
        var endDate = new Date(PrDate);

        if (startDate.getTime() < endDate.getTime()) {
            return (
                <span className="listitem_time"> <a href="/" className="join_btn" onClick={this.setMatchSession(matchId)}>Join</a></span>
            );
        } else {
            return (
                <span className="listitem_time"> <a href="/" className="join_btn">View</a></span>
            );
        }
    }
    /* 
        @method: getMatchList
        @var: array
        @description: call auth method web services get match list
    */
    getMatchList = () => {
        let Url = URL + '/server/api/v1/match/matches';
        let stateData = { login_session_key: Auth.getToken() };
        let option = { method: 'POST', body: JSON.stringify(stateData) };
        Auth.fetch(Url, option)
            .then((res) => {
                this.setState({ match: res.response });
            });
    }
    /* 
        @method: setMatchSession
        @var: matchId
        @description: set match id in session
    */
    setMatchSession = (matchId) => {
        localStorage.setItem('matchId', matchId);
    }
    /* 
        @method: matchList
        @var: matchData
        @description: Match list DOM component for ready to render
    */
    matchList(matchData) {
        var settings = {
            dots: true,
            infinite: true,
            speed: 500,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: 1,
            slidesToShow: 3,
            dotsClass: "slick-dots",
            useCSS: false
        };
        var CountD = (number) => {
            return this.countDownStart(number.d[0], number.d[1]);
        }

        var IsMatchViewOrClosed = (n) => {
            return this.isMatchCheckClosed(n.dates[0], n.dates[1], n.dates[2]);
        }
        var Matches = this.state.match.map(function (match_list) {
            return <div className="slick_item" key={match_list.match_id}>
                <div className="slick_item_inner">
                    <div className="listitem_header"> {match_list.match_num}
                    </div>
                    <div className="listitem_content">
                        <ul>
                            <li>
                                <span className="text-info">( {match_list.localteam} )   Vs </span> <span className="text-info">( {match_list.visitorteam} )</span>
                                <a href="/" className="cloud_icon">
                                    <i className="flaticon-timer"></i>
                                    {/* {match_list.match_date+" "+match_list.match_time} */}
                                    <CountD d={[match_list.match_date, match_list.match_time]} />
                                </a>
                            </li>
                            <li>
                                <span>
                                </span>
                                <IsMatchViewOrClosed dates={[match_list.match_date, match_list.match_time, match_list.match_id]} />
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        })
        return (
            <Slider {...settings}>
                {Matches}
            </Slider>
        )

    }

    render() {
        return (
            <div>
                {this.matchList()}
            </div>
        );
    }
}

export default Match;