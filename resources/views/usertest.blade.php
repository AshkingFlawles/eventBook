<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>UserTest Table</title>

  <!-- ✅ Load React and ReactDOM from CDN (development versions) -->
  <script crossorigin src="https://unpkg.com/react@18/umd/react.development.js"></script>
  <script crossorigin src="https://unpkg.com/react-dom@18/umd/react-dom.development.js"></script>

  <!-- ✅ Load Babel to allow writing JSX directly in the browser -->
  <script src="https://unpkg.com/babel-standalone@6/babel.min.js"></script>

  <!-- ✅ Load Tailwind CSS for utility-first styling -->
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<!-- ✅ Apply background and padding globally to the body -->
<body class="bg-gray-100 p-6">

  <!-- ✅ Root element where React will mount your component -->
  <div id="root" class="max-w-5xl mx-auto"></div>

  <!-- ✅ Tell Blade to ignore the JSX inside -->
  @verbatim
  <script type="text/babel">
    // ✅ Destructure hooks from React
    const { useState, useEffect } = React;

    // ✅ This is your main React component
    function UserTestTable() {
      // ✅ Declare state variables using React Hooks
      // users: stores the paginated user data and metadata
      const [users, setUsers] = useState({ data: [] });

      // page: the current page number
      const [page, setPage] = useState(1);

      // perPage: how many users to show per page (10, 25, 50)
      const [perPage, setPerPage] = useState(10);

      // loading: true while fetching data
      const [loading, setLoading] = useState(false);

      // error: store any error message from fetch failures
      const [error, setError] = useState("");

      // ✅ useEffect runs after every render IF any dependency changes
      // Here it runs every time `page` or `perPage` changes
      useEffect(() => {
        setLoading(true);       // Start loading spinner
        setError("");           // Clear old error

        // ✅ Fetch paginated users from Laravel backend
        fetch(`/api/int?page=${page}&per_page=${perPage}`)
          .then(res => {
            if (!res.ok) throw new Error("Failed to fetch users");
            return res.json();
          })
          .then(data => setUsers(data))     // ✅ Save the JSON response in state
          .catch(err => setError(err.message)) // ✅ If error, save the message
          .finally(() => setLoading(false));   // ✅ Hide loading spinner when done
      }, [page, perPage]);

      // ✅ Go to next page (unless already at last page)
      const nextPage = () => {
        if (page < users.last_page) {
          setPage(page + 1);
        }
      };

      // ✅ Go to previous page (unless already at first page)
      const prevPage = () => {
        if (page > 1) {
          setPage(page - 1);
        }
      };

      // ✅ Handle dropdown change (10, 25, 50 per page)
      const handlePerPageChange = (e) => {
        setPerPage(Number(e.target.value)); // ✅ Update perPage state
        setPage(1); // ✅ Reset to first page to avoid being out of range
      };

      // ✅ Render JSX (HTML-like) layout
      return (
        <div className="bg-white p-6 rounded-xl shadow-md">
          {/* ✅ Title */}
          <h2 className="text-2xl font-semibold text-center mb-4 text-gray-700">
            UserTest Table
          </h2>

          {/* ✅ Per-page dropdown selector */}
          <div className="mb-4 flex items-center justify-end">
            <label className="mr-2 text-gray-600 font-medium">Users per page:</label>
            <select
              value={perPage}
              onChange={handlePerPageChange}
              className="border border-gray-300 rounded px-2 py-1"
            >
              <option value="10">10</option>
              <option value="25">25</option>
              <option value="50">50</option>
            </select>
          </div>

          {/* ✅ Display error if something went wrong */}
          {error && (
            <div className="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
              {error}
            </div>
          )}

          {/* ✅ Show loading message while data is fetching */}
          {loading ? (
            <div className="text-center text-gray-500 py-8">Loading...</div>
          ) : users.data.length === 0 ? (
            // ✅ If no users returned
            <div className="text-center text-gray-500 py-8">No users found.</div>
          ) : (
            // ✅ Display the table of users
            <table className="min-w-full border-collapse border border-gray-300">
              <thead>
                <tr className="bg-gray-800 text-white">
                  <th className="px-4 py-2 border">ID</th>
                  <th className="px-4 py-2 border">Name</th>
                  <th className="px-4 py-2 border">Email</th>
                  <th className="px-4 py-2 border">Verified At</th>
                </tr>
              </thead>
              <tbody>
                {users.data.map(user => (
                  <tr key={user.id} className="hover:bg-gray-100">
                    <td className="px-4 py-2 border">{user.id}</td>
                    <td className="px-4 py-2 border">{user.name}</td>
                    <td className="px-4 py-2 border">{user.email}</td>
                    <td className="px-4 py-2 border">{user.email_verified_at || "N/A"}</td>
                  </tr>
                ))}
              </tbody>
            </table>
          )}

          {/* ✅ Pagination buttons */}
          <div className="flex justify-between items-center mt-6">
            {/* Previous button */}
            <button
              onClick={prevPage}
              disabled={page === 1 || loading}
              className="bg-blue-500 text-white px-4 py-2 rounded disabled:opacity-50"
            >
              Previous
            </button>

            {/* Current page number */}
            <span className="text-gray-700">
              Page {page} of {users.last_page || 1}
            </span>

            {/* Next button */}
            <button
              onClick={nextPage}
              disabled={page === users.last_page || loading}
              className="bg-blue-500 text-white px-4 py-2 rounded disabled:opacity-50"
            >
              Next
            </button>
          </div>
        </div>
      );
    }

    // ✅ Mount the React component inside the #root div
    const root = ReactDOM.createRoot(document.getElementById("root"));
    root.render(<UserTestTable />);
  </script>
  @endverbatim
</body>
</html>
