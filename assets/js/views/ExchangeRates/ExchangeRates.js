import React, {Component} from 'react';
import axios from "axios";
import DatePicker from "./components/DatePicker";
import ExchangeRatesTable from "./components/ExchangeRatesTable";

class ExchangeRates extends Component {

    state = {
        loading: true,
        selectedDate: null,
        todayRates: [],
        ratesByDate: [],
        error: {
            message: null
        }
    }

    componentDidMount() {
        const selectedDate = this.getSelectedDateFromURL();

        this.setState({selectedDate}, this.fetchDefaultExchangeRates);
    }

    getSelectedDateFromURL() {
        const {location} = this.props;
        const urlParams = new URLSearchParams(location.search);
        const timestamp = urlParams.get('byDate');

        return timestamp && !isNaN(timestamp) ? timestamp : null;
    }

    getBaseUrl() {
        return window.location.origin;
    }

    async fetchExchangeRates(date = null) {
        try {
            const url = `${this.getBaseUrl()}/api/exchange-rates${date ? `?byDate=${date}` : ''}`;
            const response = await axios.get(url);

            return response.data.data;
        } catch (error) {
            throw new Error(error.response?.data?.error || 'An error occurred while fetching exchange rates.');
        }
    }

    async fetchDefaultExchangeRates() {
        this.setState({loading: true});
        try {
            const todayRates = await this.fetchExchangeRates();
            this.setState({todayRates});
        } catch (error) {
            this.setState({error: {message: error.message}});
        } finally {
            this.setState({loading: false});
        }
    };

    updateURLWithDate(date) {
        const {location, history} = this.props;
        const urlParams = new URLSearchParams(location.search);

        if (date) {
            urlParams.set('byDate', date);
        } else {
            urlParams.delete('byDate');
        }

        history.replace({
            pathname: location.pathname,
            search: urlParams.toString(),
        });
    }

    async setSelectedDate(date) {
        this.setState({selectedDate: date, loading: true});
        this.updateURLWithDate(date);

        try {
            const ratesByDate = await this.fetchExchangeRates(date);
            this.setState({ratesByDate});
        } catch (error) {
            this.setState({error: {message: error.message}});
        } finally {
            this.setState({loading: false});
        }
    };

    render() {
        const {loading, error, todayRates, ratesByDate} = this.state

        return (
            <div>
                <section className="row-section">
                    <div className="container">
                        <div className="row">
                            <div className="col-md-10 mx-auto">
                                <h2 className="text-center my-5"><span>Kursy walut</span> by Sviatoslav Zhovtiak</h2>

                                <div>
                                    <DatePicker onSelectDate={this.setSelectedDate.bind(this)} disabled={loading}/>
                                    {error.message && <div className="alert alert-danger" role="alert">
                                        {error.message}
                                    </div>}
                                </div>

                                {loading ? (
                                    <div className={'text-center'}>
                                        <span className="fa fa-spin fa-spinner fa-4x"></span>
                                    </div>
                                ) : (
                                    <ExchangeRatesTable ratesByDate={ratesByDate} todayRates={todayRates}/>
                                )}
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        );
    }
}

export default ExchangeRates;