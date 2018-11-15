/* eslint-disable */
import React from 'react';
import ReactDOM from 'react-dom';
import Export from './components/reactify'

for(let prop in Export.reactors)
{
    if(typeof Export.reactors[prop] === "object" && Export.reactors[prop])
    {
        for( let Comp in Export.reactors[prop])
        {
            let targets = document.querySelectorAll(prop);
            let Component = Export.reactors[prop][Comp]
            targets.forEach(element => {
                console.log(element)
                ReactDOM.render(
                    <Component data={element.dataset}/>,
                    element
                );
            })
        }
    }

}