import React, {Component} from 'react';

class ExchangeRatesTable extends Component {
    render() {
        const {todayRates, ratesByDate, selectedDate} = this.props
        const dataLength = todayRates.length

        return (
            <div>
                <table className="table">
                    <thead>
                    <tr>
                        <th scope="col">Waluta</th>
                        <th scope="col" className="buy-indicator">Kupno</th>
                        <th scope="col" className="sell-indicator">Sprzedaż</th>
                    </tr>
                    </thead>
                    <tbody>
                    {Array.from({length: dataLength}).map((_, i) => {
                        const todayRate = todayRates[i]
                        const rateByDate = ratesByDate[i]

                        return (
                            <React.Fragment key={i}>
                                <tr>
                                    <td>
                                        <div className="d-flex flex-column">
                                            <b>{todayRate.code} <small>({todayRate.currency})</small></b>
                                            <small>Dane z dnia dzisiejszego</small>
                                        </div>
                                    </td>
                                    <td className="vertical-center buy-indicator">{todayRate.buyRate ?? '-'} PLN</td>
                                    <td className="vertical-center sell-indicator">{todayRate.sellRate ?? '-'} PLN</td>
                                </tr>
                                {rateByDate && <tr>
                                    <td>
                                        <small>Dane z {selectedDate}</small>
                                    </td>
                                    <td className="vertical-center buy-indicator">{rateByDate.buyRate ?? '-'} PLN</td>
                                    <td className="vertical-center sell-indicator">{rateByDate.sellRate ?? '-'} PLN</td>
                                </tr>}
                            </React.Fragment>
                        )
                    })}
                    </tbody>
                </table>
            </div>
        );
    }
}

export default ExchangeRatesTable;