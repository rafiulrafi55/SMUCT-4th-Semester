#include <bits/stdc++.h>
using namespace std;

struct Edge {
    int source;
    int destination;
    int weight;
};

class Graph {
    int n;
    vector<Edge> edgeList;
public:
    Graph(int V) {
        n = V;
    }
    void addEdge(int u, int v, int w) {
        edgeList.push_back({u, v, w});
    }
    
    void BellmanFord(int src) {
        vector<int> dist(n, INT_MAX);
        dist[src] = 0;
        
        for (int i=0; i<n-1; i++) {
            for (auto& e : edgeList) {
                int u = e.source;
                int v = e.destination;
                int w = e.weight;
                
                if (dist[u] != INT_MAX && dist[u] + w < dist[v])
                    dist[v] = dist[u] + w;
            }
        }
        
        // Do it for extra one time to check negative weighted cycle
        for (auto& e : edgeList) {
            int u = e.source;
            int v = e.destination;
            int w = e.weight;
            
            if (dist[u] != INT_MAX && dist[u] + w < dist[v]) {
                cout << "negative weighted cycle found!!!\n";
                return;
            }
        }
        
        for (int i=0; i<n; i++)
            cout << "Shortest path from " << src << " to " << i << " = " << dist[i] << endl;
    }
    
};

int main() {

    Graph g(5);
    
    g.addEdge(0,1,-1);
    g.addEdge(0,2,4);
    g.addEdge(1,2,3);
    g.addEdge(1,3,2);
    g.addEdge(1,4,2);
    g.addEdge(3,2,5);
    g.addEdge(3,1,1);
    g.addEdge(4,3,-3);

    g.BellmanFord(0);

    return 0;
}