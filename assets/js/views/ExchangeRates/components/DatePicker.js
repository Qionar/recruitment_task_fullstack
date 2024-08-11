import React, {Component} from 'react';

class DatePicker extends Component {

    MIN_ALLOWED_DATE = '2023-01-01'

    MAX_ALLOWED_DATE = new Date().toISOString().split('T')[0]

    handleDateChange(e) {
        const value = e.target.value

        if (!value) {
            return;
        }

        this.props.onSelectDate(value)
    }

    render() {
        const {selectedDate} = this.props

        return (
            <div className="row">
                <div className="col">
                    <div className="form-group text-left">
                        <label htmlFor="date-picker">Wskaż date z której chcesz pobrać kurs walut</label>
                        <input
                            value={selectedDate}
                            id="date-picker"
                            type="date"
                            className="form-control"
                            min={this.MIN_ALLOWED_DATE}
                            max={this.MAX_ALLOWED_DATE}
                            onChange={this.handleDateChange.bind(this)}
                        />
                    </div>
                </div>
            </div>
        );
    }
}

export default DatePicker;