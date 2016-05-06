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

    constructor(props) {
        super(props);
        this.state = {
            data: []
        };
    }

    componentDidMount() {
        if (!!window.EventSource) {
            var source = new EventSource(this.props.source);
        } else {
            console.log('not suported')
        }

        var __self = this;
        source.addEventListener('message', function (e) {
            if (JSON.parse(e.data).length == 0) {
                this.close();
            } else {
                __self.setState({data: JSON.parse(e.data)});
            }
        }, false);

    }

    render() {
        return (
            <table className="grid">
                <tbody>
                {this.state.data.map(this.renderRow.bind(this)) }
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
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 1, 1, 0, 0, 1, 1, 0, 1, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
];
var actions = {
    toggle: function (coordinate, current) {
        console.log(this.data[coordinate.y][coordinate.x]);
        this.data[coordinate.y][coordinate.x] = 0;
        return this;
    }
};


ReactDOM.render(
    <Grid source={ '/gol/10x10' } toggle={ actions.toggle }/>,
    document.getElementById('root')
);