import {  useState } from "react";


import Iframe from "../components/Iframe";

import { COGNITREK_BACKEND_URL, XDAM_FRONTEND_URL } from "../config/constants";

const Resources = () => {

  const [showResource, setShowResource] = useState(false);
  const [resourceId, setResourceId] = useState('');

  const action = (message: string) => {
    console.log('Message received:', message);
    if (message === 'list') {
      setShowResource(false);
    }
    if (message === 'resource') {
      setShowResource(true);
      setResourceId('9df6f257-4ad4-44a6-b3ca-6dc97216b8ca');
    }
  }

  return (
    <div className="h-full relative">
      <Iframe 
        src={`${XDAM_FRONTEND_URL}/home?frame=true&core=document`} 
        title="Resource's List" 
        style={{
          width: '100%', 
          height: 'calc(100vh - 100px)',
          position: 'absolute',
          top: 0,
          left: 0,
        }}
        requestMessage={action}
        message={{ type: 'cognitrek', content: 'READY', id:1}}
      />
      { showResource && resourceId && (
        <div className="bg-slate-400 w-full absolute top-0 left-0 flex flex-col" style={{height: 'calc(100vh - 100px)'}}>
     
          <Iframe 
            src={`${COGNITREK_BACKEND_URL}/visor/${resourceId}?tm=${new Date().getTime()}`} 
            title="Resource" 
            className="flex-1"
            requestMessage={action}
          />
        </div>
      )}
    </div>
  );
};

export default Resources;