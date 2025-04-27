import {  useState } from "react";


import Iframe from "../components/Iframe";

import { COGNITREK_BACKEND_URL, XDAM_FRONTEND_URL } from "../config/constants";
import Visor from "./Visor";
import Editor from "../components/Editor";
import { useAuthStore } from "../store/authStore";

const Resources = () => {

  const [showResource, setShowResource] = useState(false);
  const [resourceId, setResourceId] = useState('');
  const [visor, setVisor] = useState(false)
  const [type, setType] = useState('list')
  const {user} = useAuthStore.getState();

  const action = (message: string, data: string, postMessage) => {
    console.log('Message received:', message, data);
    if (resourceId !== data) setResourceId(data)
    if (message === 'list') {
      setShowResource(false);
      setType('list')
    }
    if (message === 'resource') {
      setShowResource(true);
      setResourceId(data);
    }
    if (message === 'visor') {
      setVisor(!visor)
      setType('visor')
    }

    if (message === 'editor') {
      setType('editor')
    }
    if (message === 'READY' ) {
      postMessage({type: 'cognitrek:token', content: {token: user?.token, data}, id: 2}, '*')
    }
  }


  return (
    <div className="h-full relative">
      { type == 'list' && (
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
          message={{ type: 'cognitrek', content: 'READY', id:1, token: user?.token }}
        />
      )}
      { showResource && resourceId !== '' && (
        <div className="bg-slate-400 w-full absolute top-0 left-0 flex flex-col" style={{height: 'calc(100vh - 100px)'}}>
     
          <Iframe 
            src={`${COGNITREK_BACKEND_URL}/visor/${resourceId}?tm=${new Date().getTime()}`} 
            title="Resource" 
            className="flex-1"
            requestMessage={action}
          />
        </div>
      )}
      {type == 'visor' && ( <Visor resourceId={resourceId}  /> )}
      {type == 'editor' && ( <Editor resourceId={resourceId} /> )}
    </div>
  );
};

export default Resources;