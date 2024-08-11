import React, {Component} from 'react';

class DatePicker extends Component {

    MIN_ALLOWED_DATE = '2023-01-01'

    MAX_ALLOWED_DATE = new Date()

    state = {
        selectedDate: null
    }

    handleDateChange(e) {
        const value = e.target.value

        if (!value) {
            return;
        }

        this.setState({selectedDate: value})
        this.props.onSelectDate(value)
    }

    render() {
        const {disabled} = this.props

        return (
            <div className="row">
                <div className="col">
                    <div className="form-group text-left">
                        <label htmlFor="date-picker">Wskaż date z której chcesz pobrać kurs walut</label>
                        <input
                            disabled={disabled}
                            id="date-picker"
                            type="date"
                            className="form-control"
                            min={this.MIN_ALLOWED_DATE}
                            onBlur={this.handleDateChange.bind(this)}
                        />
                    </div>
                </div>
            </div>
        );
    }
}

export default DatePicker;