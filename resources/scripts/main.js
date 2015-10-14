var React = require('react');
var ReactDOM = require('react-dom');

export default class Tile extends React.Component {
    render() {
        const style = this.props.alive ? {backgroundColor: '#fff'} : null;
        return (
            <td className="tile"
                onMouseOver={ this.onMouseOver.bind(this) }
                onMouseDown={ this.onMouseDown.bind(this) }
                style={ style }></td>
        );
    }

    onMouseDown(e) {
        if (e.nativeEvent.which !== 1) {
            return;
        }
        this.props.toggle(this.props.alive);
    }

    onMouseOver(e) {
        if (e.nativeEvent.which !== 1) {
            return;
        }
        this.props.toggle(this.props.alive);
    }
}

export default class Grid extends React.Component {

    render() {
        return (
            <table className="grid">
                <tbody>
                { this.props.data.map(this.renderRow.bind(this)) }
                </tbody>
            </table>
        );
    }

    renderRow(row, y) {
        return (
            <tr key={ y }>
                { row.map(this.renderTile(y)) }
            </tr>
        );
    }

    renderTile(y) {
        return (alive, x) =>
            React.createElement(Tile, {
                key: x,
                toggle: this.toggle(y, x),
                alive
            });
    }

    toggle(y, x) {
        return (alive) => this.props.toggle({y, x}, alive);
    }
}

var data = [
    [0, 1, 1, 0, 0, 1, 1, 0, 1, 0, 0],
    [0, 1, 1, 0, 0, 1, 1, 0, 1, 0, 0],
    [0, 1, 1, 0, 0, 1, 1, 0, 1, 0, 0],
    [0, 1, 1, 0, 0, 1, 1, 0, 1, 0, 0],
    [0, 1, 1, 0, 0, 1, 1, 0, 1, 0, 0],
    [0, 1, 1, 0, 0, 1, 1, 0, 1, 0, 0],
    [0, 1, 1, 0, 0, 1, 1, 0, 1, 0, 0],
    [0, 1, 1, 0, 0, 1, 1, 0, 1, 0, 0],
    [0, 1, 1, 0, 0, 1, 1, 0, 1, 0, 0],
    [0, 1, 1, 0, 0, 1, 1, 0, 1, 0, 0],
];
var actions = {
    toggle: function (coordinate, current) {
        console.log(this.data[coordinate.y][coordinate.x]);
        this.data[coordinate.y][coordinate.x] = 0;
        return this;
    }
};


ReactDOM.render(
    <Grid data={ data } toggle={ actions.toggle }/>,
    document.getElementById('root')
);

$.ajax({
    method: 'post',
    contentType: "application/json; charset=utf-8",
    data: JSON.stringify(data),
    url: 'gol/10x10',
    dataType: 'json',
    cache: false,
    success: function (data) {
        ReactDOM.render(
            <Grid data={ data } toggle={ actions.toggle }/>,
            document.getElementById('root')
        );
    }.bind(this),
    error: function (xhr, status, err) {
        console.error(this.props.url, status, err.toString());
    }.bind(this)
});
