const Home = () => {
  return (
    <div className="flex items-center justify-center h-screen px-16 pb-28">
        
        <div className="flex flex-col sm:flex-row  items-center sm:items-start">
          <div className="w-full sm:w-1/2">
            <div className="relative aspect-square max-w-md mx-auto">
              <img
                src="/home.gif"
                alt="Illustrative image of education"
                className="rounded-lg  object-cover"
              />
              <a className="italic text-xs absolute bottom-16 left-7" href="https://storyset.com/education">Education illustrations by Storyset</a>
            </div>
          </div>
          <div className="w-full sm:w-1/2">
            <div className="p-6">
              <blockquote className="space-y-2">
                <p className="text-xl sm:text-2xl font-serif italic text-gray-800 max-w-[40ch]">
                  "Education is not the answer to the question. Education is the means to find the answer to all
                  questions."
                </p>
                <footer className="text-right text-gray-500 dark:text-gray-400">— William Allin</footer>
              </blockquote>
            </div>
          </div>
        </div>
    </div>
  );
};

export default Home;
