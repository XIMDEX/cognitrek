import Iframe from "../components/Iframe";

import { XDAM_FRONTEND_URL } from "../config/constants";

const Resources = () => {
  
  return (
    <div className="h-full">
      <Iframe src={`${XDAM_FRONTEND_URL}/home?frame=true&core=document`} title="Resource's List" style={{width: '100%', height: 'calc(100vh - 100px)'}}  />
    </div>
  );
};

export default Resources;