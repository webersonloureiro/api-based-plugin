import { useState, useEffect } from '@wordpress/element';
import apiFetch from '@wordpress/api-fetch';

function request(url) {
  const [ data, setData ] = useState([]);
  const [ loading, setLoading ] = useState(true);

  useEffect( () => {
    apiFetch( { path: url } )
    .then( ( response ) => {
      setData( Object.entries( response ) );
    })
    .then( () => {
      setLoading( false );
    })
  }, [] );

  return [ data, loading ];

}

export { request };
