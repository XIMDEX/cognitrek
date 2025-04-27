import { useCallback, useEffect, useRef, useState } from "react";
interface IframeProps {
  src: string;
  title: string;
  style?: React.CSSProperties;
  className?: string;
  message?: { type: string; content: string; id: number, token?: string };
  requestMessage?: (message: string, data: string, postMessage) => void;
}

export default function Iframe({
  src,
  title,
  style,
  className,
  message,
  requestMessage,
}: IframeProps) {
  const iframeRef = useRef<HTMLIFrameElement>(null);

  const [iframeReady, setIframeReady] = useState(false);

  const sendMessageToIframe = useCallback(() => {
    if (message?.id === undefined) return;
    if (iframeReady && src && message) {
        
        iframeRef.current?.contentWindow?.postMessage(message, new URL(src).origin);
    }
  }, [src, iframeReady, message, iframeRef]);

  useEffect(() => {
    sendMessageToIframe();
  }, [sendMessageToIframe]);

  useEffect(() => {
    const handleMessage = (event: MessageEvent) => {
      if (event.origin !== new URL(src).origin) return;

      const { type, content, data = null } = event.data;

      if (type === "cognitrek" && content === "READY") {
        if (new URL(src).origin === event.origin && !iframeReady) {
            setIframeReady(true);
        }
      }

      if (type === "cognitrek") {
        console.log("Mensaje recibido del iframe:", content);
        requestMessage?.(content, data,  iframeRef.current?.contentWindow?.postMessage);
      }
    };

    window.addEventListener("message", handleMessage);

    return () => {
      window.removeEventListener("message", handleMessage);
    };
  }, [requestMessage, iframeReady, src]);

  return (
    <iframe
      ref={iframeRef}
      src={src}
      title={title}
      style={{ border: "none", ...style }}
      className={className}
    />
  );
}
