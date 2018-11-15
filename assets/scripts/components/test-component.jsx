import React, { Component } from 'react';
import styled from 'styled-components';

class App extends Component {

    constructor(props) {
        super(props)
        this.dataSet = this.props.data;
    }

    render() {
        const Title = styled.h1`
        color: ${this.dataSet.color || "goldenrod"};
      `;
        return (
            <Title className={this.props.data.class}>{this.props.data.title}</Title>
        );
    }
}

export default App;