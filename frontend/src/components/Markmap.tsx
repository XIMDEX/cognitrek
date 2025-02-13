import { useState, useRef, useEffect } from 'react';
import { Markmap } from 'markmap-view';
import { Toolbar } from 'markmap-toolbar';
import 'markmap-toolbar/dist/style.css';
import { loadCSS, loadJS } from 'markmap-common';
import { Transformer } from 'markmap-lib';
import * as markmap from 'markmap-view';

const transformer = new Transformer();

const { scripts, styles } = transformer.getAssets();
if (styles) {
  loadCSS(styles);
}
if (scripts) loadJS(scripts, { getMarkmap: () => markmap });


function renderToolbar(mm: Markmap, wrapper: HTMLElement) {
  while (wrapper?.firstChild) wrapper.firstChild.remove();
  if (mm && wrapper) {
    const toolbar = new Toolbar();
    toolbar.attach(mm);
    // Register custom buttons
    // toolbar.register({
    //   id: 'alert',
    //   title: 'Click to show an alert',
    //   content: 'Alert',
    //   onClick: () => alert('You made it!'),
    // });
    // toolbar.setItems([...Toolbar.defaultItems, 'alert']);
    wrapper.append(toolbar.render());
  }
}

export default function MarkMap({markmap}: {markmap: string}) {
  const [value] = useState(markmap);
  const refSvg = useRef<SVGSVGElement>(null);
  const refMm = useRef<Markmap | null>(null);
  const refToolbar = useRef<HTMLDivElement>(null);

  useEffect(() => {
    if (refSvg.current && refMm.current && refToolbar.current) {
      const mm = Markmap.create(refSvg.current);
      refMm.current = mm;
      renderToolbar(refMm.current, refToolbar.current);
    }
  }, []);

  useEffect(() => {
    const mm = refMm.current;
    if (!mm) return;
    const { root } = transformer.transform(value);
    mm.setData(root);
    mm.fit();
  }, [value]);


  return (
    <div className='relative w-full h-full'>
      <svg className="h-full w-full" ref={refSvg} />
      <div className="absolute right-0 h-11 bottom-[100px]" ref={refToolbar}></div>
    </div>
  );
}
