import React, { Component } from 'react';
import styled from 'styled-components';

const Title = styled.h1`
  color: goldenrod;
`;

class App extends Component {
    render() {
        return (
            <Title>Mystagram</Title>
        );
    }
}

export default App;
